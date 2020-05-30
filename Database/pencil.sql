-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2019 at 01:04 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pencil`
--

-- --------------------------------------------------------

--
-- Table structure for table `mp_banks`
--

CREATE TABLE `mp_banks` (
  `id` int(11) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `branchcode` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `accountno` varchar(100) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_bank_opening`
--

CREATE TABLE `mp_bank_opening` (
  `id` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `bank_id` int(11) NOT NULL,
  `amount` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_bank_transaction`
--

CREATE TABLE `mp_bank_transaction` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `transaction_status` int(1) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `cleared_date` date NOT NULL,
  `total_paid` decimal(11,3) NOT NULL,
  `attachment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_bank_transaction_payee`
--

CREATE TABLE `mp_bank_transaction_payee` (
  `tran_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `payee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_barcode`
--

CREATE TABLE `mp_barcode` (
  `id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `random_no` varchar(255) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_brand`
--

CREATE TABLE `mp_brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_brand_sector`
--

CREATE TABLE `mp_brand_sector` (
  `id` int(11) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_category`
--

CREATE TABLE `mp_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `register_date` date NOT NULL,
  `status` int(1) NOT NULL,
  `added_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_drivers`
--

CREATE TABLE `mp_drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `lisence` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `cus_picture` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_estimate`
--

CREATE TABLE `mp_estimate` (
  `id` int(11) NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `date` date NOT NULL,
  `expire_date` date NOT NULL,
  `user` varchar(255) NOT NULL,
  `memo` longtext NOT NULL,
  `payee_id` int(11) NOT NULL,
  `billing` varchar(255) NOT NULL,
  `invoicemessage` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_estimate_sales`
--

CREATE TABLE `mp_estimate_sales` (
  `id` int(11) NOT NULL,
  `estimate_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `tax` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_expense`
--

CREATE TABLE `mp_expense` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `total_paid` decimal(11,3) NOT NULL,
  `date` date NOT NULL,
  `user` varchar(255) NOT NULL,
  `method` varchar(50) NOT NULL,
  `description` longtext NOT NULL,
  `payee_id` int(11) NOT NULL,
  `ref_no` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_generalentry`
--

CREATE TABLE `mp_generalentry` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `naration` varchar(255) NOT NULL,
  `generated_source` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_head`
--

CREATE TABLE `mp_head` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nature` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `relation_id` int(11) NOT NULL,
  `expense_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_head`
--

INSERT INTO `mp_head` (`id`, `name`, `nature`, `type`, `relation_id`, `expense_type`) VALUES
(1, 'Salary', 'Expense', 'Current', 0, 'Cash Expense'),
(2, 'Cash', 'Assets', 'Non-Current', 0, 'Non-Cash Expense'),
(3, 'Inventory', 'Assets', 'Current', 0, '-'),
(4, 'Accounts receivable', 'Assets', 'Current', 0, '-'),
(5, 'Accounts payable', 'Libility', 'Current', 0, 'Cash Expense'),
(6, 'Telephone Expense', 'Expense', 'Current', 0, '-'),
(7, 'CapitalStock', 'Equity', 'Current', 0, '-'),
(8, 'Land', 'Assets', 'Non-Current', 0, '-'),
(9, 'Building', 'Assets', 'Non-Current', 0, '-'),
(10, 'Notes payable', 'Libility', 'Non-Current', 0, '-'),
(11, 'Tools and Equipments', 'Assets', 'Current', 0, '-'),
(12, 'Repair Service Revenue', 'Revenue', 'Current', 0, '-'),
(13, 'Wages Expense', 'Expense', 'Current', 0, '-'),
(14, 'Utitlity Expense', 'Expense', 'Current', 0, 'Cash Expense'),
(15, 'Adverstising Expense', 'Expense', 'Current', 0, '-'),
(16, 'Cash in bank', 'Assets', 'Current', 0, '-'),
(17, 'Collection fee', 'Expense', 'Current', 0, 'Bank Expense'),
(18, 'Cost of goods', 'Expense', 'Current', 0, 'Cash Expense'),
(19, 'Sales', 'Revenue', 'Current', 0, '-'),
(20, 'Tax payable', 'Libility', 'Non-Current', 0, '-');

-- --------------------------------------------------------

--
-- Table structure for table `mp_invoices`
--

CREATE TABLE `mp_invoices` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `discount` decimal(11,3) NOT NULL,
  `status` int(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  `agentname` varchar(100) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `cus_picture` varchar(255) NOT NULL,
  `delivered_to` varchar(100) NOT NULL,
  `delivered_by` varchar(100) NOT NULL,
  `delivered_date` date NOT NULL,
  `delivered_description` varchar(255) NOT NULL,
  `shippingcharges` decimal(11,3) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `payment_method` int(1) NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `total_paid` decimal(11,3) NOT NULL,
  `source` int(1) NOT NULL,
  `store_id` int(11) NOT NULL,
  `sales_man_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_langingpage`
--

CREATE TABLE `mp_langingpage` (
  `id` int(11) NOT NULL,
  `companyname` varchar(255) NOT NULL,
  `companydescription` varchar(255) NOT NULL,
  `companykeywords` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `slider1` varchar(255) NOT NULL,
  `slider2` varchar(255) NOT NULL,
  `slider3` varchar(255) NOT NULL,
  `slider4` varchar(255) NOT NULL,
  `slider5` varchar(255) NOT NULL,
  `title1` varchar(255) NOT NULL,
  `title2` varchar(255) NOT NULL,
  `title3` varchar(255) NOT NULL,
  `title4` varchar(255) NOT NULL,
  `title5` varchar(255) NOT NULL,
  `title6` varchar(255) NOT NULL,
  `subtitle6` varchar(255) NOT NULL,
  `subtitle6one` varchar(255) NOT NULL,
  `title8` varchar(255) NOT NULL,
  `title9` varchar(255) NOT NULL,
  `title10` varchar(255) NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(50) NOT NULL,
  `primarycolor` varchar(50) NOT NULL,
  `theme_pri_hover` varchar(50) NOT NULL,
  `expirey` int(11) NOT NULL,
  `startday` int(2) NOT NULL,
  `startmonth` int(2) NOT NULL,
  `endday` int(2) NOT NULL,
  `endmonth` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_langingpage`
--

INSERT INTO `mp_langingpage` (`id`, `companyname`, `companydescription`, `companykeywords`, `address`, `email`, `contact`, `logo`, `banner`, `slider1`, `slider2`, `slider3`, `slider4`, `slider5`, `title1`, `title2`, `title3`, `title4`, `title5`, `title6`, `subtitle6`, `subtitle6one`, `title8`, `title9`, `title10`, `currency`, `language`, `primarycolor`, `theme_pri_hover`, `expirey`, `startday`, `startmonth`, `endday`, `endmonth`) VALUES
(1, 'Pencil v3.0  | The Retail Store and Distribution Software ', 'Pencil v3.0  | The Retail Store and Distribution Software ', 'Distribtuions', 'Puniyal Road', 'prince.tr@gmail.com', '05811-0000', '51b63bf127b40ff104c6f78234657de4.png', '099a9c4f11df62b5430d3265a74c5778.png', '0ae082ea4c6d3334de39a11840c07c09.jpg', 'a3cbfa5f37d75bd8de678ceded28da43.png', 'd6e2b9bad5eb6560699d95d0235b3e9e.png', '67e008061660613ba4497979db422f91.png', 'ec572d4564b40dec3412b2d305f6a59e.png', 'PRINCE TRADERS GILGIT', 'PRINCE TRADERS GILGIT', 'PRINCE TRADERS GILGIT', 'PRINCE TRADERS GILGIT', 'PRINCE TRADERS GILGIT', 'PRINCE TRADERS GILGIT', 'PRINCE TRADERS GILGIT', 'PRINCE TRADERS GILGIT', 'Quick Links.', 'Follow us.', '© Copyright Shop PRo developed by North Soft Gilgit. All Rights Reserved.', 'PKR', 'EN', '#d3af08', '#aaa106', 5, 1, 1, 31, 12);

-- --------------------------------------------------------

--
-- Table structure for table `mp_menu`
--

CREATE TABLE `mp_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_menu`
--

INSERT INTO `mp_menu` (`id`, `name`, `icon`) VALUES
(1, 'Products', 'fa fa-life-ring'),
(2, 'Settings', 'fa fa-cog'),
(5, 'Reports', 'fa fa-balance-scale'),
(6, 'POS', 'fa fa-clipboard'),
(7, 'Profile', 'fa fa-user'),
(12, 'Roles', 'fa fa-users'),
(18, 'Bank', 'fa fa-bank'),
(20, 'Purchase', 'fa fa-briefcase'),
(21, 'Supply ', 'fa fa-flask'),
(22, 'Initilization', 'fa fa-anchor'),
(23, 'Accounts', 'fa fa-calculator'),
(24, 'Statements', 'fa fa-line-chart'),
(25, 'Options', 'fa fa-shopping-bag'),
(26, 'Dashboard', 'fa fa-dashboard'),
(27, 'Expense', 'fa fa-paper-plane'),
(29, 'Vouchers', 'fa fa-newspaper-o'),
(30, 'Service', 'fa fa-lemon-o'),
(31, 'Extra ', 'fa fa-plus-circle'),
(32, 'Extra Links', 'fa fa-plus-circle');

-- --------------------------------------------------------

--
-- Table structure for table `mp_menulist`
--

CREATE TABLE `mp_menulist` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_menulist`
--

INSERT INTO `mp_menulist` (`id`, `menu_id`, `title`, `link`) VALUES
(1, 1, 'Products', 'product'),
(2, 1, 'Categories', 'category'),
(3, 2, 'Layout & System', 'layout'),
(10, 5, 'Sales Report', 'sales_report'),
(13, 6, 'View Invoice', 'invoice/manage'),
(16, 7, 'Personal', 'profile'),
(17, 25, 'Users', 'users'),
(18, 25, 'Requested items', 'todolist'),
(26, 12, 'Multiple Roles', 'multiple_roles'),
(29, 27, 'Expense', 'Expense'),
(30, 18, 'Cheques', 'bank/written_cheque'),
(31, 18, 'Banks', 'bank'),
(34, 1, 'Pending stock', 'product/pending_stock'),
(36, 6, 'Create invoice', 'invoice'),
(37, 6, 'Return items', 'return_items'),
(38, 5, 'Return report', 'sales_report/return_item_report'),
(39, 20, 'Purchases', 'purchase'),
(40, 21, 'Supply List', 'supply'),
(41, 21, 'Drivers', 'supply/drivers'),
(42, 21, 'Vehicles', 'supply/vehicle'),
(43, 22, 'Brands', 'initilization'),
(44, 22, 'Brand Sector', 'initilization/brand_sector'),
(45, 22, 'Region', 'initilization/region'),
(46, 22, 'Towns', 'initilization/town'),
(47, 22, 'units', 'initilization/units'),
(48, 22, 'Stores', 'initilization/stores'),
(49, 1, 'Out of stock', 'stock_alert_report'),
(50, 1, 'Recent expired', 'product/expired_list'),
(51, 1, 'Stock ', 'product/product_stock'),
(52, 1, 'Expired Stock', 'product/expired_stock'),
(56, 20, 'Purchase return', 'purchase/return_list'),
(57, 4, 'Customer payments', 'customers/payment_list '),
(58, 23, 'Chart of accounts', 'accounts'),
(59, 24, 'General Journal', 'statements'),
(60, 24, 'Ledger Account', 'statements/ledger_accounts'),
(61, 24, 'Trail Balance', 'statements/trail_balance'),
(62, 24, 'Income', 'statements/income_statement'),
(63, 24, 'Balance Sheet', 'statements/balancesheet'),
(65, 23, 'Opening Account Heads', 'vouchers'),
(68, 31, 'Take Backup', 'backup'),
(69, 25, 'Restore Backup', 'backup/upload_restore'),
(70, 18, 'Bank Deposits', 'bank/deposit_list'),
(71, 18, 'Bank Book', 'bank/bank_book'),
(72, 26, 'Dashboard', 'homepage'),
(73, 25, 'Printer Settings', 'Printer_settings'),
(77, 31, 'Company', 'Company'),
(78, 20, 'Purchase Order', 'Purchase_order'),
(79, 21, 'Salesman', 'supply/sales_man'),
(80, 5, 'Top Customers', 'sales_report/top_customers'),
(81, 5, 'Top Salesman', 'sales_report/top_salesman'),
(82, 5, 'Brands report', 'sales_report/brand_sale'),
(83, 5, 'Section report', 'sales_report/brand_section'),
(84, 5, 'Company Wise', 'sales_report/company_wise'),
(85, 5, 'Storewise report', 'sales_report/store_wise'),
(86, 5, 'SKU Wise', 'Sales_report/sku_wise'),
(88, 24, 'Bank Reconciliation', 'statements/bank_reconciliation'),
(89, 18, 'Bank Collection', 'Bank/payment_collection'),
(90, 27, 'Bank Expense', 'Expense/bank_expense'),
(91, 21, 'Order List', 'Order_list'),
(92, 29, 'Credit Voucher', 'vouchers/credit_vouchers'),
(93, 29, 'Debit Voucher', 'vouchers/payments'),
(94, 29, 'Journal voucher', 'vouchers/journal_list'),
(95, 23, 'Account Holders ', 'payee'),
(96, 31, 'Estimate', 'estimate'),
(97, 31, 'Sales receipt', 'sales_receipt'),
(98, 30, 'Services', 'services'),
(99, 23, 'Opening Balances', 'vouchers/open_user_account');

-- --------------------------------------------------------

--
-- Table structure for table `mp_multipleroles`
--

CREATE TABLE `mp_multipleroles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `menu_Id` int(11) NOT NULL,
  `role` int(1) NOT NULL,
  `agentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_multipleroles`
--

INSERT INTO `mp_multipleroles` (`id`, `user_id`, `menu_Id`, `role`, `agentid`) VALUES
(117, 1, 12, 0, 1),
(118, 1, 1, 1, 1),
(119, 1, 2, 1, 1),
(120, 1, 5, 1, 1),
(121, 1, 6, 1, 1),
(122, 1, 7, 1, 1),
(124, 1, 18, 1, 1),
(125, 1, 20, 1, 1),
(126, 1, 21, 1, 1),
(127, 1, 22, 1, 1),
(128, 1, 23, 1, 1),
(129, 1, 24, 1, 1),
(130, 1, 25, 1, 1),
(132, 1, 27, 1, 1),
(134, 1, 26, 1, 1),
(135, 3, 1, 1, 1),
(136, 3, 6, 1, 1),
(137, 3, 12, 1, 1),
(139, 3, 18, 1, 1),
(140, 3, 20, 1, 1),
(141, 3, 23, 1, 1),
(142, 3, 24, 1, 1),
(143, 3, 26, 1, 1),
(144, 3, 27, 1, 1),
(146, 1, 29, 1, 1),
(147, 1, 30, 1, 1),
(148, 1, 31, 1, 1),
(149, 4, 1, 1, 1),
(150, 4, 5, 1, 1),
(151, 4, 6, 1, 1),
(152, 4, 18, 1, 1),
(153, 4, 20, 1, 1),
(154, 4, 21, 1, 1),
(155, 4, 22, 1, 1),
(156, 4, 23, 1, 1),
(157, 4, 24, 1, 1),
(159, 4, 27, 1, 1),
(160, 4, 29, 1, 1),
(161, 4, 30, 1, 1),
(162, 4, 31, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mp_order_list_total`
--

CREATE TABLE `mp_order_list_total` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `agentid` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `total_amount` decimal(11,3) NOT NULL,
  `cash` decimal(11,3) NOT NULL,
  `credit_amount` decimal(11,3) NOT NULL,
  `cheque_amount` decimal(11,3) NOT NULL,
  `schemes` decimal(11,3) NOT NULL,
  `bank_deposit` decimal(11,3) NOT NULL,
  `return_stock_val` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_payee`
--

CREATE TABLE `mp_payee` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `cus_email` varchar(50) NOT NULL,
  `cus_password` varchar(255) NOT NULL,
  `cus_address` varchar(255) NOT NULL,
  `cus_contact_1` varchar(50) NOT NULL,
  `cus_contact_2` varchar(50) NOT NULL,
  `cus_company` varchar(50) NOT NULL,
  `cus_description` varchar(100) NOT NULL,
  `cus_picture` varchar(100) NOT NULL,
  `cus_status` int(1) NOT NULL,
  `cus_region` varchar(255) NOT NULL,
  `cus_town` varchar(255) NOT NULL,
  `cus_type` varchar(50) NOT NULL,
  `cus_balance` decimal(11,3) NOT NULL,
  `cus_date` date NOT NULL,
  `customer_nationalid` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_payment_voucher`
--

CREATE TABLE `mp_payment_voucher` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `payee_id` int(11) NOT NULL,
  `receipt_date` date NOT NULL,
  `memo` varchar(255) NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `total_paid` decimal(11,3) NOT NULL,
  `user` varchar(50) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_printer`
--

CREATE TABLE `mp_printer` (
  `id` int(11) NOT NULL,
  `printer_name` varchar(255) NOT NULL,
  `fontsize` int(11) NOT NULL,
  `set_default` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_printer`
--

INSERT INTO `mp_printer` (`id`, `printer_name`, `fontsize`, `set_default`) VALUES
(6, 'Black Copper BC-85AC', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mp_product`
--

CREATE TABLE `mp_product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `cost` decimal(11,3) NOT NULL,
  `sale_tax` decimal(11,3) NOT NULL,
  `head_id` int(11) NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_productslist`
--

CREATE TABLE `mp_productslist` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `mg` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase` decimal(11,3) NOT NULL,
  `retail` decimal(11,3) NOT NULL,
  `expire` date NOT NULL,
  `manufacturing` date NOT NULL,
  `sideeffects` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `min_stock` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `total_units` int(11) NOT NULL,
  `packsize` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `tax` decimal(11,3) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `brand_sector_id` int(11) NOT NULL,
  `unit_type` varchar(50) NOT NULL,
  `net_weight` varchar(50) NOT NULL,
  `whole_sale` decimal(11,3) NOT NULL,
  `pack_cost` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_purchase`
--

CREATE TABLE `mp_purchase` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `payment_type_id` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `total_paid` decimal(11,3) NOT NULL,
  `discount` decimal(11,3) NOT NULL,
  `cus_picture` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_purchase_order`
--

CREATE TABLE `mp_purchase_order` (
  `id` int(11) NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `date` date NOT NULL,
  `expire_date` date NOT NULL,
  `user` varchar(255) NOT NULL,
  `memo` longtext NOT NULL,
  `payee_id` int(11) NOT NULL,
  `billing` varchar(255) NOT NULL,
  `invoicemessage` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_region`
--

CREATE TABLE `mp_region` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_return`
--

CREATE TABLE `mp_return` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `cus_id` int(11) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `total_paid` decimal(11,3) NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `discount_given` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_return_list`
--

CREATE TABLE `mp_return_list` (
  `id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `product_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `mg` varchar(255) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `purchase` decimal(11,3) NOT NULL,
  `qty` int(11) NOT NULL,
  `tax` decimal(11,3) NOT NULL,
  `mode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_sales`
--

CREATE TABLE `mp_sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_no` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `mg` int(11) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `discount` int(11) NOT NULL,
  `purchase` decimal(11,3) NOT NULL,
  `qty` int(11) NOT NULL,
  `tax` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_salesman`
--

CREATE TABLE `mp_salesman` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `cus_picture` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_sales_orderlist`
--

CREATE TABLE `mp_sales_orderlist` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `opening_stock` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `product_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `mg` varchar(255) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `purchase` decimal(11,3) NOT NULL,
  `qty` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `tax` decimal(11,3) NOT NULL,
  `source` varchar(50) NOT NULL,
  `pack` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_sales_receipt`
--

CREATE TABLE `mp_sales_receipt` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `user` varchar(255) NOT NULL,
  `payee_id` int(11) NOT NULL,
  `method` varchar(255) NOT NULL,
  `ref_no` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `total_bill` decimal(11,3) NOT NULL,
  `total_paid` decimal(11,3) NOT NULL,
  `invoicemessage` varchar(255) NOT NULL,
  `memo` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_sessions`
--

CREATE TABLE `mp_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mp_sessions`
--

INSERT INTO `mp_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('1g61mmtigabliiqgls87unubhh3nr24c', '::1', 1549425550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432353535303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('22ik6cg5rmao2vca4pr1sv4lfk2avifm', '::1', 1549497604, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439373630343b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('2vpf9q9085rc1n3v1f75q07v25cg1mrk', '::1', 1549423522, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432333532323b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('3ab2hpnlcst4n7bhs39g0gpthm9dg1e0', '::1', 1549492924, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439323932343b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d7374617475737c613a323a7b733a333a226d7367223b733a39313a223c69207374796c653d22636f6c6f723a236666662220636c6173733d2266612066612d636865636b2d636972636c652d6f2220617269612d68696464656e3d2274727565222f3e20557064617465207375636365737366756c6c79223b733a353a22616c657274223b733a343a22696e666f223b7d5f5f63695f766172737c613a313a7b733a363a22737461747573223b733a333a226e6577223b7d),
('3duh05ktl7i0oaboh5taml2b58tcs20r', '::1', 1549492589, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439323538393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('3ebs138sggqditm9gr7ohq8j6fnbi6f8', '::1', 1549493286, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439333238363b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('3vr6prg004vbabds19pc0h6fjrnpftia', '::1', 1549496900, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439363930303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('4oallso5uslaoimvsj40lvcllvofa32m', '::1', 1549700787, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393730303738373b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('5oj44trkmc4mhgvducr5rp3mind0gmfh', '::1', 1549594513, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393539343531333b),
('640gif74vpckn320os32h601s865kgq0', '::1', 1549711723, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393731313732333b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('74dmti1e0gvpvk9e38i761rdgjnccv08', '::1', 1549498430, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439383433303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('752gkmfad7d94msccjvuh7hmtt9lon20', '::1', 1549499040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439393034303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('7oa0hloaf8cesqphb3s41sf30rk9t313', '::1', 1549713275, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393731333036333b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('7re5c8etvq9fl94ugujvjcu7k6kfb86d', '::1', 1549497978, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439373937383b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('88erjp47qksbs3vi9nfti7gkpl3krd0e', '::1', 1549498736, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439383733363b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('8valc1ujuk0ip5dqsg7pv59ghd3np6v3', '::1', 1549490873, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439303837333b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('93i3t6d0a446h620q60ni03hajnvnjbm', '::1', 1549424578, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432343537383b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('a1812oom4thkn9ud4fceb1s92rpkkq2j', '::1', 1549427846, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432373834363b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('ap93gj810pr2ca7ot6iodoo5qjlda39g', '::1', 1549497249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439373234393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('b1eeb8kgl9ct40n7r65tj6kp40l1q70h', '::1', 1549488862, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393438383836323b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('bqntif4dvi9ouva0j9ed8p701mtm686e', '::1', 1549427240, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432373234303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('brqnusesb7cqbia431a8g0esfhtvf6ca', '::1', 1549712024, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393731323032343b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d7374617475737c613a323a7b733a333a226d7367223b733a39353a223c69207374796c653d22636f6c6f723a236666662220636c6173733d2266612066612d636865636b2d636972636c652d6f2220617269612d68696464656e3d2274727565223e3c2f693e2043726561746564205375636365737366756c6c79223b733a353a22616c657274223b733a343a22696e666f223b7d5f5f63695f766172737c613a313a7b733a363a22737461747573223b733a333a226f6c64223b7d),
('c9e5pbmn9umq7o5hpobr44n81teboc3o', '::1', 1549428174, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432383137343b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('cd0gc6iv6bq8hvlbjentmhg1ajk75a4q', '::1', 1549427541, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432373534313b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('cdkig10a7mrlmqk5nei7haboocr3j34s', '::1', 1549712613, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393731323631333b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('dtpako3qintmfctsmrb9mpqpgadd5c8i', '::1', 1549502509, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393530323530393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('e4cat8o99ordu4pt8ugajhhl1bfv41ps', '::1', 1549503880, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393530333838303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('ei7omhr8rb72s27qk6cai9fa3f3phgmq', '::1', 1549426606, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432363630363b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d7374617475737c613a323a7b733a333a226d7367223b733a3132313a223c69207374796c653d22636f6c6f723a236666662220636c6173733d2266612066612d636865636b2d636972636c652d6f2220617269612d68696464656e3d2274727565223e3c2f693e20496e766f696365207375636365737366756c6c20627574206e6f207072696e746572206973206465647563746564223b733a353a22616c657274223b733a343a22696e666f223b7d5f5f63695f766172737c613a313a7b733a363a22737461747573223b733a333a226f6c64223b7d),
('elteuipgftilm6tb9vek9305sen8n3qa', '::1', 1549426907, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432363930373b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('f375eusjobumlfp7a96ktc5p7v5iilkj', '::1', 1549504111, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393530333838303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('fj8jon5sdrvbi780lecgjj4tsa7mvemv', '::1', 1549701110, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393730313131303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('fu0dfnlcrjj4dkkm2ea2ntqrrdforo5p', '::1', 1549423849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432333834393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('ge11dge5q87bli2lm0aek1cc8f5i6noq', '::1', 1549429233, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432393233333b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('gkubk5bimbs5dfchblr0g2pv595l0j8o', '::1', 1549594592, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393539343531333b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d7374617475737c613a323a7b733a333a226d7367223b733a39343a223c69207374796c653d22636f6c6f723a236666662220636c6173733d2266612066612d636865636b2d636972636c652d6f2220617269612d68696464656e3d2274727565223e3c2f693e204c6f67696e20205375636365737366756c6c79223b733a353a22616c657274223b733a343a22696e666f223b7d5f5f63695f766172737c613a313a7b733a363a22737461747573223b733a333a226f6c64223b7d),
('h63p5c1r63cuh5open890a824378gftd', '::1', 1549431249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393433313234393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('h9426blpt6lnv7nbur2fvfpe2kqrf1ec', '::1', 1549493655, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439333635353b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('hr9ulj2ni4upcetfhuhmmjsa1s7lri6v', '::1', 1549430572, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393433303537323b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('hu1lojkq0e8j40uta4pafobpilckrebm', '::1', 1549428930, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432383933303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('ir2m9vmrot8qi4cps6i3m1sv19e80oah', '::1', 1549502957, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393530323935373b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('jk4e0ebd91a122ks8g5l585fhkpn857l', '::1', 1549503272, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393530333237323b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('klqaftujk2k9srb7sn7jmshokch7bsad', '::1', 1549424194, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432343139343b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('kodg5hfatomitvq39kphtsfgvkr6kanc', '::1', 1549501834, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393530313833343b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d7374617475737c613a323a7b733a333a226d7367223b733a3130323a223c69207374796c653d22636f6c6f723a236666662220636c6173733d2266612066612d636865636b2d636972636c652d6f2220617269612d68696464656e3d2254525545223e3c2f693e2070726976696c6567657320616c72656164792061737369676e6564223b733a353a22616c657274223b733a363a2264616e676572223b7d5f5f63695f766172737c613a313a7b733a363a22737461747573223b733a333a226f6c64223b7d),
('llsk606ehurec7a29juaf2g0cc4t9b91', '::1', 1549432286, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393433323139393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('m6hpspaq6ogohjuv524imfjnte0rh8j2', '::1', 1549502173, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393530323137333b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('m9bcv4nlpv44nm97ju5kquiunn3s8nag', '::1', 1549426268, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432363236383b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('o8gclsku8osl2rcukmansa55kkmapf21', '::1', 1549431841, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393433313834313b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('p3n2qn4epoahbmq1a291bjuigcu40oda', '::1', 1549701429, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393730313432393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('qglfa8830rr4p8j42bls6bduekl78bgp', '::1', 1549713063, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393731333036333b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('qq9qq4v3v8ru3at278q25v26najmlo75', '::1', 1549425032, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432353033323b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('rbemam07b4v5a0b87oa26lm97a7luinj', '::1', 1549493990, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439333939303b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d7374617475737c613a323a7b733a333a226d7367223b733a39353a223c69207374796c653d22636f6c6f723a236666662220636c6173733d2266612066612d636865636b2d636972636c652d6f2220617269612d68696464656e3d2274727565223e3c2f693e2043726561746564205375636365737366756c6c79223b733a353a22616c657274223b733a343a22696e666f223b7d5f5f63695f766172737c613a313a7b733a363a22737461747573223b733a333a226f6c64223b7d),
('scsuumdn1906j96qbocvf04og1k859p1', '::1', 1549432199, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393433323139393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('sgallumajmqv0v0hdmthltfhjrnglgdo', '::1', 1549430887, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393433303838373b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('sp188n1n4hj7hn5g43t7ghi3egr3mmqg', '::1', 1549429858, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393432393835383b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('udg7eqi4mlg3qoje305eblfqdoq6cq0s', '::1', 1549494449, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393439343434393b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d),
('upcfagl3nvkq4c712pjdq8uaonkmburc', '::1', 1549430261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534393433303236313b757365725f69647c613a323a7b733a323a226964223b733a313a2231223b733a343a226e616d65223b733a353a2241646d696e223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `mp_stock`
--

CREATE TABLE `mp_stock` (
  `id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `manufacturing` date NOT NULL,
  `expiry` date NOT NULL,
  `qty` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `added` varchar(255) NOT NULL,
  `purchase` decimal(11,3) NOT NULL,
  `selling` decimal(11,3) NOT NULL,
  `pack_retail_price` decimal(11,3) NOT NULL,
  `pack_purchase_price` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_stores`
--

CREATE TABLE `mp_stores` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_subpo_details`
--

CREATE TABLE `mp_subpo_details` (
  `id` int(11) NOT NULL,
  `estimate_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `tax` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_sub_entry`
--

CREATE TABLE `mp_sub_entry` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `accounthead` int(11) NOT NULL,
  `amount` decimal(11,3) NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_sub_expense`
--

CREATE TABLE `mp_sub_expense` (
  `id` int(11) NOT NULL,
  `expense_id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_sub_purchase`
--

CREATE TABLE `mp_sub_purchase` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `cost` decimal(11,3) NOT NULL,
  `retail` decimal(11,3) NOT NULL,
  `pack_cost` decimal(11,3) NOT NULL,
  `pack_retail` decimal(11,3) NOT NULL,
  `wholesale` decimal(11,3) NOT NULL,
  `qty` int(11) NOT NULL,
  `manu_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `source` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_sub_receipt`
--

CREATE TABLE `mp_sub_receipt` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `tax` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_supply`
--

CREATE TABLE `mp_supply` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `region_id` int(11) NOT NULL,
  `town_id` int(11) NOT NULL,
  `expense` decimal(11,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_temp_barcoder_invoice`
--

CREATE TABLE `mp_temp_barcoder_invoice` (
  `id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `product_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `mg` varchar(255) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `purchase` decimal(11,3) NOT NULL,
  `qty` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `tax` double(11,2) NOT NULL,
  `agentid` int(11) NOT NULL,
  `source` varchar(50) NOT NULL,
  `pack` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_temp_barcoder_order`
--

CREATE TABLE `mp_temp_barcoder_order` (
  `id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `opening_stock` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `product_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `mg` varchar(255) NOT NULL,
  `price` decimal(11,3) NOT NULL,
  `purchase` decimal(11,3) NOT NULL,
  `qty` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `tax` double(11,2) NOT NULL,
  `agentid` int(11) NOT NULL,
  `source` varchar(50) NOT NULL,
  `pack` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_temp_purchase`
--

CREATE TABLE `mp_temp_purchase` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `cost` decimal(11,3) NOT NULL,
  `retail` decimal(11,3) NOT NULL,
  `pack_cost` decimal(11,3) NOT NULL,
  `pack_retail` decimal(11,3) NOT NULL,
  `wholesale` decimal(11,3) NOT NULL,
  `qty` int(11) NOT NULL,
  `manu_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `agentid` int(11) NOT NULL,
  `source` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_todolist`
--

CREATE TABLE `mp_todolist` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `addedby` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_town`
--

CREATE TABLE `mp_town` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp_units`
--

CREATE TABLE `mp_units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_units`
--

INSERT INTO `mp_units` (`id`, `name`, `symbol`) VALUES
(1, 'Kilogram', 'Kg'),
(2, 'Mililetre', 'Ml'),
(3, 'Liter', 'ltr'),
(4, 'Pieces', 'Pcs'),
(5, 'Carton', 'Crtn'),
(6, 'Grams', 'GM');

-- --------------------------------------------------------

--
-- Table structure for table `mp_users`
--

CREATE TABLE `mp_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_contact_1` varchar(50) NOT NULL,
  `user_contact_2` varchar(50) NOT NULL,
  `cus_picture` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `user_description` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_date` date NOT NULL,
  `agentname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_users`
--

INSERT INTO `mp_users` (`id`, `user_name`, `user_email`, `user_address`, `user_contact_1`, `user_contact_2`, `cus_picture`, `status`, `user_description`, `user_password`, `user_date`, `agentname`) VALUES
(1, 'Admin', 'name@email.com', 'Gilgit Baltistan', '03112036611', '', '8dab55cd278bf6c8c0f86c004dfdce74.png', 0, 'admin', '8cb2237d0679ca88db6464eac60da96345513964', '2017-08-23', 'Admin'),
(4, 'Demo', 'demo@gmail.com', '', '', '', 'default.jpg', 0, '', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-01-29', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `mp_vehicle`
--

CREATE TABLE `mp_vehicle` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `vehicle_id` varchar(255) NOT NULL,
  `chase_no` varchar(255) NOT NULL,
  `engine_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mp_vehicle`
--

INSERT INTO `mp_vehicle` (`id`, `name`, `number`, `vehicle_id`, `chase_no`, `engine_no`, `date`, `status`) VALUES
(1, 'Suzuki', 'dsd', 'Ravi', 'sdas', 'sadasd', '2019-02-07', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mp_banks`
--
ALTER TABLE `mp_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_bank_opening`
--
ALTER TABLE `mp_bank_opening`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `mp_bank_transaction`
--
ALTER TABLE `mp_bank_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `mp_bank_transaction_payee`
--
ALTER TABLE `mp_bank_transaction_payee`
  ADD PRIMARY KEY (`tran_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `payee_id` (`payee_id`);

--
-- Indexes for table `mp_barcode`
--
ALTER TABLE `mp_barcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_brand`
--
ALTER TABLE `mp_brand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `mp_brand_sector`
--
ALTER TABLE `mp_brand_sector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_category`
--
ALTER TABLE `mp_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `mp_drivers`
--
ALTER TABLE `mp_drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_estimate`
--
ALTER TABLE `mp_estimate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payee_id` (`payee_id`);

--
-- Indexes for table `mp_estimate_sales`
--
ALTER TABLE `mp_estimate_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`estimate_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `mp_expense`
--
ALTER TABLE `mp_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `payee_id` (`payee_id`);

--
-- Indexes for table `mp_generalentry`
--
ALTER TABLE `mp_generalentry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_head`
--
ALTER TABLE `mp_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_invoices`
--
ALTER TABLE `mp_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `prescription_id` (`prescription_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `sales_man_id` (`sales_man_id`),
  ADD KEY `invoice_driver_fk` (`driver_id`),
  ADD KEY `invoice_region_fk` (`region_id`),
  ADD KEY `invoice_vehicle_fk` (`vehicle_id`);

--
-- Indexes for table `mp_langingpage`
--
ALTER TABLE `mp_langingpage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_menu`
--
ALTER TABLE `mp_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_menulist`
--
ALTER TABLE `mp_menulist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `mp_multipleroles`
--
ALTER TABLE `mp_multipleroles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `menu_Id` (`menu_Id`),
  ADD KEY `agentid` (`agentid`);

--
-- Indexes for table `mp_order_list_total`
--
ALTER TABLE `mp_order_list_total`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_payee`
--
ALTER TABLE `mp_payee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_payment_voucher`
--
ALTER TABLE `mp_payment_voucher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `payee_id` (`payee_id`);

--
-- Indexes for table `mp_printer`
--
ALTER TABLE `mp_printer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_product`
--
ALTER TABLE `mp_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_id` (`head_id`);

--
-- Indexes for table `mp_productslist`
--
ALTER TABLE `mp_productslist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `brand_sector_id` (`brand_sector_id`),
  ADD KEY `unit_type` (`unit_type`);

--
-- Indexes for table `mp_purchase`
--
ALTER TABLE `mp_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `mp_purchase_order`
--
ALTER TABLE `mp_purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payee_id` (`payee_id`);

--
-- Indexes for table `mp_region`
--
ALTER TABLE `mp_region`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_return`
--
ALTER TABLE `mp_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `mp_return_list`
--
ALTER TABLE `mp_return_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`return_id`),
  ADD KEY `medicine_id` (`product_id`);

--
-- Indexes for table `mp_sales`
--
ALTER TABLE `mp_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `mp_salesman`
--
ALTER TABLE `mp_salesman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_sales_orderlist`
--
ALTER TABLE `mp_sales_orderlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `mp_sales_receipt`
--
ALTER TABLE `mp_sales_receipt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `payee_id` (`payee_id`);

--
-- Indexes for table `mp_sessions`
--
ALTER TABLE `mp_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `mp_stock`
--
ALTER TABLE `mp_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mid` (`mid`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `mp_stores`
--
ALTER TABLE `mp_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_subpo_details`
--
ALTER TABLE `mp_subpo_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`estimate_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `mp_sub_entry`
--
ALTER TABLE `mp_sub_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sid` (`parent_id`),
  ADD KEY `accounthead` (`accounthead`),
  ADD KEY `amount` (`amount`);

--
-- Indexes for table `mp_sub_expense`
--
ALTER TABLE `mp_sub_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_id` (`expense_id`),
  ADD KEY `head_id` (`head_id`);

--
-- Indexes for table `mp_sub_purchase`
--
ALTER TABLE `mp_sub_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `subpurchase_product_fk` (`mid`);

--
-- Indexes for table `mp_sub_receipt`
--
ALTER TABLE `mp_sub_receipt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_id` (`sales_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `mp_supply`
--
ALTER TABLE `mp_supply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `region_id` (`region_id`),
  ADD KEY `town_id` (`town_id`);

--
-- Indexes for table `mp_temp_barcoder_invoice`
--
ALTER TABLE `mp_temp_barcoder_invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `agentid` (`agentid`);

--
-- Indexes for table `mp_temp_barcoder_order`
--
ALTER TABLE `mp_temp_barcoder_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `agentid` (`agentid`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `salesman_id` (`salesman_id`);

--
-- Indexes for table `mp_temp_purchase`
--
ALTER TABLE `mp_temp_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_todolist`
--
ALTER TABLE `mp_todolist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addedby` (`addedby`);

--
-- Indexes for table `mp_town`
--
ALTER TABLE `mp_town`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_units`
--
ALTER TABLE `mp_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `symbol` (`symbol`);

--
-- Indexes for table `mp_users`
--
ALTER TABLE `mp_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `user_name_2` (`user_name`);

--
-- Indexes for table `mp_vehicle`
--
ALTER TABLE `mp_vehicle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mp_banks`
--
ALTER TABLE `mp_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_bank_opening`
--
ALTER TABLE `mp_bank_opening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_bank_transaction`
--
ALTER TABLE `mp_bank_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_bank_transaction_payee`
--
ALTER TABLE `mp_bank_transaction_payee`
  MODIFY `tran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_barcode`
--
ALTER TABLE `mp_barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_brand`
--
ALTER TABLE `mp_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_brand_sector`
--
ALTER TABLE `mp_brand_sector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_category`
--
ALTER TABLE `mp_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_drivers`
--
ALTER TABLE `mp_drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_estimate`
--
ALTER TABLE `mp_estimate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_estimate_sales`
--
ALTER TABLE `mp_estimate_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_expense`
--
ALTER TABLE `mp_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_generalentry`
--
ALTER TABLE `mp_generalentry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_head`
--
ALTER TABLE `mp_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `mp_invoices`
--
ALTER TABLE `mp_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_langingpage`
--
ALTER TABLE `mp_langingpage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mp_menu`
--
ALTER TABLE `mp_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `mp_menulist`
--
ALTER TABLE `mp_menulist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `mp_multipleroles`
--
ALTER TABLE `mp_multipleroles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `mp_order_list_total`
--
ALTER TABLE `mp_order_list_total`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_payee`
--
ALTER TABLE `mp_payee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_payment_voucher`
--
ALTER TABLE `mp_payment_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_printer`
--
ALTER TABLE `mp_printer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mp_product`
--
ALTER TABLE `mp_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_productslist`
--
ALTER TABLE `mp_productslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_purchase`
--
ALTER TABLE `mp_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_purchase_order`
--
ALTER TABLE `mp_purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_region`
--
ALTER TABLE `mp_region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_return`
--
ALTER TABLE `mp_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_return_list`
--
ALTER TABLE `mp_return_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_sales`
--
ALTER TABLE `mp_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_salesman`
--
ALTER TABLE `mp_salesman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_sales_orderlist`
--
ALTER TABLE `mp_sales_orderlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_sales_receipt`
--
ALTER TABLE `mp_sales_receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_stock`
--
ALTER TABLE `mp_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mp_stores`
--
ALTER TABLE `mp_stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_subpo_details`
--
ALTER TABLE `mp_subpo_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_sub_entry`
--
ALTER TABLE `mp_sub_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_sub_expense`
--
ALTER TABLE `mp_sub_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_sub_purchase`
--
ALTER TABLE `mp_sub_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_sub_receipt`
--
ALTER TABLE `mp_sub_receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_supply`
--
ALTER TABLE `mp_supply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_temp_barcoder_invoice`
--
ALTER TABLE `mp_temp_barcoder_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_temp_barcoder_order`
--
ALTER TABLE `mp_temp_barcoder_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_temp_purchase`
--
ALTER TABLE `mp_temp_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mp_todolist`
--
ALTER TABLE `mp_todolist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_town`
--
ALTER TABLE `mp_town`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mp_units`
--
ALTER TABLE `mp_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mp_users`
--
ALTER TABLE `mp_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mp_vehicle`
--
ALTER TABLE `mp_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mp_bank_opening`
--
ALTER TABLE `mp_bank_opening`
  ADD CONSTRAINT `opening_bank_id` FOREIGN KEY (`bank_id`) REFERENCES `mp_banks` (`id`);

--
-- Constraints for table `mp_bank_transaction`
--
ALTER TABLE `mp_bank_transaction`
  ADD CONSTRAINT `bankid_bank_fk` FOREIGN KEY (`bank_id`) REFERENCES `mp_banks` (`id`),
  ADD CONSTRAINT `transaction_general_fk` FOREIGN KEY (`transaction_id`) REFERENCES `mp_generalentry` (`id`);

--
-- Constraints for table `mp_bank_transaction_payee`
--
ALTER TABLE `mp_bank_transaction_payee`
  ADD CONSTRAINT `bank_general_transaction_fk` FOREIGN KEY (`transaction_id`) REFERENCES `mp_generalentry` (`id`),
  ADD CONSTRAINT `payee_bank_fk` FOREIGN KEY (`payee_id`) REFERENCES `mp_payee` (`id`);

--
-- Constraints for table `mp_brand`
--
ALTER TABLE `mp_brand`
  ADD CONSTRAINT `brand_company_fk` FOREIGN KEY (`company_id`) REFERENCES `mp_payee` (`id`);

--
-- Constraints for table `mp_estimate`
--
ALTER TABLE `mp_estimate`
  ADD CONSTRAINT `estimate_payee_fk` FOREIGN KEY (`payee_id`) REFERENCES `mp_payee` (`id`);

--
-- Constraints for table `mp_estimate_sales`
--
ALTER TABLE `mp_estimate_sales`
  ADD CONSTRAINT `estimate_parent_id` FOREIGN KEY (`estimate_id`) REFERENCES `mp_estimate` (`id`);

--
-- Constraints for table `mp_expense`
--
ALTER TABLE `mp_expense`
  ADD CONSTRAINT `general_expense_fk` FOREIGN KEY (`transaction_id`) REFERENCES `mp_generalentry` (`id`),
  ADD CONSTRAINT `payee_expense_fk` FOREIGN KEY (`payee_id`) REFERENCES `mp_payee` (`id`);

--
-- Constraints for table `mp_invoices`
--
ALTER TABLE `mp_invoices`
  ADD CONSTRAINT `invoice_payee_fk` FOREIGN KEY (`cus_id`) REFERENCES `mp_payee` (`id`),
  ADD CONSTRAINT `invoice_transaction_fk` FOREIGN KEY (`transaction_id`) REFERENCES `mp_generalentry` (`id`);

--
-- Constraints for table `mp_multipleroles`
--
ALTER TABLE `mp_multipleroles`
  ADD CONSTRAINT `roles_agentid_fk` FOREIGN KEY (`agentid`) REFERENCES `mp_users` (`id`),
  ADD CONSTRAINT `roles_menuid_fk` FOREIGN KEY (`menu_Id`) REFERENCES `mp_menu` (`id`),
  ADD CONSTRAINT `roles_user_fk` FOREIGN KEY (`user_id`) REFERENCES `mp_users` (`id`);

--
-- Constraints for table `mp_payment_voucher`
--
ALTER TABLE `mp_payment_voucher`
  ADD CONSTRAINT `payment_transaction_fk` FOREIGN KEY (`transaction_id`) REFERENCES `mp_generalentry` (`id`),
  ADD CONSTRAINT `pv_payee_id` FOREIGN KEY (`payee_id`) REFERENCES `mp_payee` (`id`);

--
-- Constraints for table `mp_product`
--
ALTER TABLE `mp_product`
  ADD CONSTRAINT `product_head_fk` FOREIGN KEY (`head_id`) REFERENCES `mp_head` (`id`);

--
-- Constraints for table `mp_productslist`
--
ALTER TABLE `mp_productslist`
  ADD CONSTRAINT `product_brand_fk` FOREIGN KEY (`brand_id`) REFERENCES `mp_brand` (`id`),
  ADD CONSTRAINT `product_brand_section_fk` FOREIGN KEY (`brand_sector_id`) REFERENCES `mp_brand_sector` (`id`),
  ADD CONSTRAINT `product_unit_fk` FOREIGN KEY (`unit_type`) REFERENCES `mp_units` (`symbol`);

--
-- Constraints for table `mp_purchase`
--
ALTER TABLE `mp_purchase`
  ADD CONSTRAINT `purchase_payee_fk` FOREIGN KEY (`supplier_id`) REFERENCES `mp_payee` (`id`),
  ADD CONSTRAINT `purchase_transaction_fk` FOREIGN KEY (`transaction_id`) REFERENCES `mp_generalentry` (`id`);

--
-- Constraints for table `mp_purchase_order`
--
ALTER TABLE `mp_purchase_order`
  ADD CONSTRAINT `po_payee_fk` FOREIGN KEY (`payee_id`) REFERENCES `mp_payee` (`id`);

--
-- Constraints for table `mp_return`
--
ALTER TABLE `mp_return`
  ADD CONSTRAINT `return_customer_fk` FOREIGN KEY (`cus_id`) REFERENCES `mp_payee` (`id`),
  ADD CONSTRAINT `return_transaction_general_fk` FOREIGN KEY (`transaction_id`) REFERENCES `mp_generalentry` (`id`);

--
-- Constraints for table `mp_return_list`
--
ALTER TABLE `mp_return_list`
  ADD CONSTRAINT `return_item_fk` FOREIGN KEY (`return_id`) REFERENCES `mp_return` (`id`),
  ADD CONSTRAINT `return_product_fk` FOREIGN KEY (`product_id`) REFERENCES `mp_productslist` (`id`);

--
-- Constraints for table `mp_sales`
--
ALTER TABLE `mp_sales`
  ADD CONSTRAINT `sales_invoice_fk` FOREIGN KEY (`order_id`) REFERENCES `mp_invoices` (`id`),
  ADD CONSTRAINT `sales_productlist_fk` FOREIGN KEY (`product_id`) REFERENCES `mp_productslist` (`id`);

--
-- Constraints for table `mp_sales_receipt`
--
ALTER TABLE `mp_sales_receipt`
  ADD CONSTRAINT `salesreceipt_payee_fk` FOREIGN KEY (`payee_id`) REFERENCES `mp_payee` (`id`),
  ADD CONSTRAINT `salesreceipt_transaction_fk` FOREIGN KEY (`transaction_id`) REFERENCES `mp_generalentry` (`id`);

--
-- Constraints for table `mp_stock`
--
ALTER TABLE `mp_stock`
  ADD CONSTRAINT `stock_product_fk` FOREIGN KEY (`mid`) REFERENCES `mp_productslist` (`id`);

--
-- Constraints for table `mp_subpo_details`
--
ALTER TABLE `mp_subpo_details`
  ADD CONSTRAINT `po_sub_fk` FOREIGN KEY (`estimate_id`) REFERENCES `mp_purchase_order` (`id`);

--
-- Constraints for table `mp_sub_entry`
--
ALTER TABLE `mp_sub_entry`
  ADD CONSTRAINT `sub_entry_fk` FOREIGN KEY (`parent_id`) REFERENCES `mp_generalentry` (`id`);

--
-- Constraints for table `mp_sub_expense`
--
ALTER TABLE `mp_sub_expense`
  ADD CONSTRAINT `subexpense_fk` FOREIGN KEY (`expense_id`) REFERENCES `mp_expense` (`id`),
  ADD CONSTRAINT `subexpense_head_fk` FOREIGN KEY (`head_id`) REFERENCES `mp_head` (`id`);

--
-- Constraints for table `mp_sub_purchase`
--
ALTER TABLE `mp_sub_purchase`
  ADD CONSTRAINT `sub_purchase_fk` FOREIGN KEY (`purchase_id`) REFERENCES `mp_purchase` (`id`),
  ADD CONSTRAINT `subpurchase_product_fk` FOREIGN KEY (`mid`) REFERENCES `mp_productslist` (`id`);

--
-- Constraints for table `mp_sub_receipt`
--
ALTER TABLE `mp_sub_receipt`
  ADD CONSTRAINT `sales_receipt_fk` FOREIGN KEY (`sales_id`) REFERENCES `mp_sales_receipt` (`id`),
  ADD CONSTRAINT `sub_productlist_fk` FOREIGN KEY (`product_id`) REFERENCES `mp_product` (`id`);

--
-- Constraints for table `mp_supply`
--
ALTER TABLE `mp_supply`
  ADD CONSTRAINT `supply_driver_fk` FOREIGN KEY (`driver_id`) REFERENCES `mp_drivers` (`id`),
  ADD CONSTRAINT `supply_region_fk` FOREIGN KEY (`region_id`) REFERENCES `mp_region` (`id`),
  ADD CONSTRAINT `supply_town_fk` FOREIGN KEY (`town_id`) REFERENCES `mp_town` (`id`),
  ADD CONSTRAINT `supply_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `mp_vehicle` (`id`);

--
-- Constraints for table `mp_temp_barcoder_invoice`
--
ALTER TABLE `mp_temp_barcoder_invoice`
  ADD CONSTRAINT `temp_agentid_fk` FOREIGN KEY (`agentid`) REFERENCES `mp_users` (`id`),
  ADD CONSTRAINT `temp_product_fk` FOREIGN KEY (`product_id`) REFERENCES `mp_productslist` (`id`);

--
-- Constraints for table `mp_temp_barcoder_order`
--
ALTER TABLE `mp_temp_barcoder_order`
  ADD CONSTRAINT `order_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `mp_brand` (`id`);

--
-- Constraints for table `mp_todolist`
--
ALTER TABLE `mp_todolist`
  ADD CONSTRAINT `todo_agent_fk` FOREIGN KEY (`addedby`) REFERENCES `mp_users` (`user_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
