<?php defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__ . '\..\..\autoload.php';
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector as WP;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer as P;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\CapabilityProfiles\EposTepCapabilityProfile;

/**
 * This is the model class for table "printers".
 */
class Printer
{

    public function testPrint($business_info)
    {
        /*require_once(dirname(__FILE__) . "/../../i18N/Arabic.php");
        $fontPath = dirname(__FILE__) . "/../../i18N/Arabic/Examples/GD/ae_AlHor.ttf";
        $textUtf8 = "صِف خَلقَ خَودِ كَمِثلِ الشَمسِ إِذ بَزَغَت — يَحظى الضَجيعُ بِها نَجلاءَ مِعطارِ";
        $maxChars = 50;
        $fontSize = 28;
        mb_internal_encoding("UTF-8");
        $Arabic = new \I18N_Arabic('Glyphs');
        $textLtr = $Arabic -> utf8Glyphs($textUtf8, $maxChars);
        $textLine = explode("\n", $textLtr);
        //$buffer = new ImagePrintBuffer();
        //$buffer -> setFont($fontPath);
        //$buffer -> setFontSize($fontSize);
        $profile = EposTepCapabilityProfile::getInstance();
        $connector = new FilePrintConnector("php://output");
        // = new WindowsPrintConnector("LPT2");
        // Windows LPT2 was used in the bug tracker
        $printer = new P($connector, $profile);
        //$printer -> setPrintBuffer($buffer);
        $printer -> setJustification(P::JUSTIFY_RIGHT);
        foreach($textLine as $text) {
            // Print each line separately. We need to do this since Imagick thinks
            // text is left-to-right
            $printer -> text($text . "\n");
        }
        $printer -> cut();
        $printer -> close();*/
        $pos = self::findOne(['type' => self::TYPE_POS, 'status' => 1, 'is_default' => 1]);

        if(! $pos) {
            throw new \Exception("No printer installed");
            
        }

        $connect = $this->getCon($business_info);
        $printer = new P($connect);
        # slip type
        // $printer -> setColor(P::COLOR_1);
        $printer -> setJustification(P::JUSTIFY_CENTER);
        $printer -> text("Purchase Slip \n");
        $printer -> feed();
        $printer -> selectPrintMode(P::MODE_FONT_B);
        $printer -> setTextSize(2, 2);
        // $printer -> setLineSpacing(1);
        // $printer -> selectPrintMode();
        $printer -> text($this->business->name . "\n");
        $printer -> setTextSize(1,1);
        $printer -> text($this->business->address . "\n");
        $printer -> text($this->business->phone_number . "\n");
        $printer -> selectPrintMode(P::FONT_B);
        $printer -> setEmphasis(true);
        $printer -> text(new item('product(s)', "QTY", 'RS'));
        $printer -> setEmphasis(false);
        $printer -> cut();
        $printer -> close();
    }
    private function getSpaceSettings()
    {
        return [
            'product' => 20,
            'price' => 10,
            'qty' => 6,
            'total' => 6,
        ];
    }
    public function generate_print($business_info,$data)
    {

        try 
        {

        $connect = new WP($business_info['printer_name']);      
        $discount = $business_info['discount'];
        /* Start the printer */
        // $logo = EscposImage::load("img/logo.jpg", false);
        $printer = new P($connect);
        // $printer = new Printer($connector);
        /* Print top logo */
        $printer -> setJustification(P::JUSTIFY_CENTER);
        // $printer -> graphics($logo);
        /* Name of shop */
        //$printer -> selectPrintMode(P::MODE_DOUBLE_WIDTH);
        $printer -> selectPrintMode(P::MODE_FONT_B);
        $printer -> setTextSize(2, 2);
        $printer-> text($business_info['name']);
        $printer->text("\n");
        $printer -> selectPrintMode();
        $printer -> setTextSize(1, 1);
        $printer-> text($business_info['address']);
    
        $printer -> feed();
        /* Title of receipt */
        $printer -> setEmphasis(true);
        $printer->text('Invoice # '.$business_info['receipt']);
        $printer->text("\n");
        $printer -> setEmphasis(false);
        $printer -> text($business_info['date'] . "\n");
        /* Items */
        if($business_info['customer']){
            $printer -> feed(); 
            $printer -> setJustification(P::JUSTIFY_LEFT);
            $printer->setTextSize(1,1);
        $printer->text('Customer : '.$business_info['customer'].'      '.'Served By : '.$business_info['served']);
        $printer->  text("\n");
        }
        // $printer -> setEmphasis(fal);
        // $printer -> text(new item('product(s)', 'QTY',  'RS', true));
        $printer -> text("______________________________________________\n");
        foreach ($this->getSpaceSettings() as $attr => $space) {
            $printer -> text(str_pad(ucwords($attr), $space, ' ', $space == 'total'  ? STR_PAD_LEFT : STR_PAD_RIGHT));
        }
        $printer -> feed();
        $printer -> text("_______________________________________________\n");
        // $printer -> setEmphasis(false);
        $s = $this->getSpaceSettings();
        $totalamount = 0;
        $totaltax = 0;
        if($data != NULL){
        foreach ($data['item_data'] as $single_item) {
            $string1 = $single_item->product_name;
            $totaltax =  $totaltax + $single_item->tax;
            $totalamount = $totalamount + $single_item->price*$single_item->qty;
            $string = (strlen($string1) > 16) ? substr($string1,0,16).'...' : $string1;
            $printer -> text($this->getPad($string, 'product'));
            $printer -> text($this->getPad($single_item->price, 'price'));
            $printer -> text($this->getPad($single_item->qty, 'qty'));
            $printer -> text($this->getPad($single_item->discount, 'discount'));
            $printer -> text($this->getPad(($single_item->price*$single_item->qty)-$single_item->discount, 'total') . "\n");
        }
        }
        $printer -> text("-----------------------------------------------\n");
        
        $printer -> feed();
        $printer -> text($this->getPad("Sub Total:", 'product'));
        $printer -> text($this->getPad('', 'price'));
        $printer -> text($this->getPad('', 'qty'));
        $printer -> text($this->getPad($totalamount, 'total') . "\n");

        $printer -> text($this->getPad("Discount:", 'product'));
        $printer -> text($this->getPad('', 'price'));
        $printer -> text($this->getPad('', 'qty'));
        $printer -> text($this->getPad($discount, 'total') . "\n");
        $total_after_dis = $totalamount-$discount;
        $hst_total_amount = $totaltax + $total_after_dis;
        $printer -> setEmphasis(true);
        $printer -> text($this->getPad("Net Total:", 'product'));
        $printer -> text($this->getPad('', 'price'));
        $printer -> text($this->getPad('', 'qty'));
        $printer -> text($this->getPad($hst_total_amount, 'total') . "\n");
    
        $printer -> setEmphasis(false);
        // $printer -> text($subtotal);

        $printer -> text("-----------------------------------------------\n");
        $printer -> feed();


        # print cash and balance information
        // $printer->setEmphasis(true);
        // $printer -> text($this->getPad("Cash Received:", 'product'));
        // $printer -> text($this->getPad("", 'price'));
        // $printer -> text($this->getPad("", 'qty'));
        // $printer -> text($this->getPad($model->payment->received, 'total') . "\n");
        
        if($business_info['customer_id'] != 2) 
        {
                # old balance
               /* if ($pos_data['old_balance']) {
                    $printer -> text($this->getPad("Old Balance:", 'product'));
                    $printer -> text($this->getPad("", 'price'));
                    $printer -> text($this->getPad("", 'qty'));
                    $printer -> text($this->getPad($pos_data["old_balance"], 'total') . "\n");
                }*/

               /* if(isset($data['bill_paid'])){
                    $printer -> text($this->getPad("Cash:", 'product'));
                    $printer -> text($this->getPad("", 'price'));
                    $printer -> text($this->getPad("", 'qty'));
                    $printer -> text($this->getPad($data['cash'], 'total') . "\n");

                } */
                    $printer -> text($this->getPad("Cash:", 'product'));
                    $printer -> text($this->getPad("", 'price'));
                    $printer -> text($this->getPad("", 'qty'));
                    $printer -> text($this->getPad($data['bill_paid'], 'total') . "\n");
               /* if(isset($pos_data["customer_collection"]) && (float) $pos_data['customer_collection'] > 0){
                    $printer -> text($this->getPad("To Collection:", 'product'));
                    $printer -> text($this->getPad("", 'price'));
                    $printer -> text($this->getPad("", 'qty'));
                    $printer -> text($this->getPad($pos_data['customer_collection'], 'total') . "\n");  
                }

                if(isset($pos_data["customer_collection"]) 
                    && ((float) $pos_data['customer_collection'] < 1
                    || (float) $pos_data['customer_collection'] == null)
                    ) {

                    # credit sale.
                    $printer -> text($this->getPad("Credit:", 'product'));
                    $printer -> text($this->getPad("", 'price'));
                    $printer -> text($this->getPad("", 'qty'));
                    $printer -> text($this->getPad($model->payment->remaining, 'total') . "\n");
                }
    */
                $printer -> text($this->getPad("New Balance:", 'product'));
                $printer -> text($this->getPad("", 'price'));
                $printer -> text($this->getPad("", 'qty'));
                //$printer -> text($this->getPad($data['cus_previous']), 'total') . "\n");
                $printer -> text($this->getPad($data['cus_previous'], 'total') . "\n");
                $printer -> text("-----------------------------------------------\n");
                $printer -> feed();
            }
                // $printer -> text($this->getPad("Cash:", 'product'));
                // $printer -> text($this->getPad("", 'price'));
                // $printer -> text($this->getPad("", 'qty'));
                // $printer -> text($this->getPad($, 'total') . "\n");

            # print
            $printer->setEmphasis(false);
            $printer -> feed();

            /* Tax and total */
            // $printer -> text($tax);
            // $printer -> selectPrintMode(P::MODE_DOUBLE_WIDTH);
            // $printer -> text($total);
            // $printer -> selectPrintMode();
            /* Footer */
            // $printer -> feed(2);
            $printer -> setJustification(P::JUSTIFY_CENTER);
            $printer ->text("Thank you for visiting us \n");
            $printer ->selectPrintMode(P::MODE_FONT_B);
            $printer ->setTextSize(1,1);    

            //$printer->text('Date : '.$business_info['date']);
            $printer->text("\n"); 
            $printer -> feed();
            $printer -> setJustification(P::JUSTIFY_LEFT);
            $printer -> selectPrintMode(P::MODE_UNDERLINE);
            $printer -> setTextSize(1, 1);
            $printer -> setFont(0);
            $printer -> text("Software Solution by North Soft Gilgit\n");
            $printer -> setJustification(P::JUSTIFY_CENTER);
            $printer -> text("03125408708 / 03112036611\n");
            // $printer -> setJustification(P::JUSTIFY_RIGHT);
            // $printer -> text("");
            $printer -> feed();
            $printer -> cut();
            $printer -> pulse();
            $printer -> close();

            $printer_result = 'success';

        } 
        catch(Exception $e) 
        {
            $printer_result = $e -> getMessage();
        }

        return $printer_result;
    }

    public function getPad($str, $attr)
    {
        return str_pad($str, $this->getSpaceSettings()[$attr], ' ', $attr == 'total' ? STR_PAD_LEFT : STR_PAD_RIGHT);
    }
}
