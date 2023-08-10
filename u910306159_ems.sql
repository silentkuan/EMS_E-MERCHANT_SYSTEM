-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2023 at 02:05 PM
-- Server version: 10.6.14-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u910306159_ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `heading1` varchar(255) DEFAULT NULL,
  `heading2` varchar(255) DEFAULT NULL,
  `btn_txt` varchar(255) DEFAULT NULL,
  `btn_link` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `heading1`, `heading2`, `btn_txt`, `btn_link`, `image`, `status`, `merchant_id`) VALUES
(1, 'Best Sell Collection', 'Girl\'s Favourite', 'Buy Now', 'http://localhost/Ecommerce_EMS/product.php?id=9', '616533770_526258680_Floral-Print-Polo-T-shirt1.jpg', 1, 1),
(2, 'Promotion Collection', 'Offer 20%', 'Check Now', 'http://localhost/Ecommerce_EMS/product.php?id=7', '522223864_309027777_Floral-Print-Polo-T-shirt.jpg', 1, 1),
(9, 'ENTER CODE TO GET OFFER123', 'UP100', 'SHOP NOW', 'https://ems-emerchantsystem.silent-dev.tech/categories.php?id=14&merchant_name=ThongHeng', '858357647_Product-2-7-1639377914.png', 1, 2),
(10, 'BUY 500 SAVE 100', 'HAPPY_500', 'GET IT NOW', 'https://ems-emerchantsystem.silent-dev.tech/product.php?id=25&merchant_name=ThongHeng', '631082116_Product-2-15-1639380423.png', 1, 2),
(13, 'Coupon Code:FRIDAY', 'FRIDAY', 'SHOP NOW', 'https://ems-emerchantsystem.silent-dev.tech/categories.php?id=17&merchant_name=ThongHeng', '949546604_Product-1-27-1639382721.jpg', 1, 2),
(17, 'Welcome', 'EZY Hair Studio', NULL, NULL, '451213606_slid.png', 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories`, `status`, `merchant_id`) VALUES
(14, 'Battery', 1, 2),
(17, 'Engine_Oils', 1, 2),
(18, 'Cosmetics', 1, 19),
(20, 'Skin Care', 1, 19),
(26, 'boy', 1, 24),
(33, 'Hair_Service', 1, 20),
(36, 'girl', 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_master`
--

CREATE TABLE `coupon_master` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `coupon_value` int(11) DEFAULT NULL,
  `coupon_type` varchar(10) DEFAULT NULL,
  `cart_min_value` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `coupon_master`
--

INSERT INTO `coupon_master` (`id`, `coupon_code`, `coupon_value`, `coupon_type`, `cart_min_value`, `status`, `merchant_id`) VALUES
(12, 'UP100', 10, 'Percentage', 100, 1, 2),
(20, 'HAPPY500', 100, 'MYR', 500, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `username`, `password`, `role_id`, `email`, `mobile`, `status`, `merchant_id`) VALUES
(6, 'ahgan', '$2y$09$fQtSu9bpngrvEMcHUdevP.w0kj8JFCXAdnFoLEn2hzAP1MIbYfn.a', '1', 'ahgan@gmail.com', '012333434', 1, 2),
(7, 'hazimi', '$2y$09$Cq6zsORohdFRdahL4Fhz2eBuFnzXOfRVP5oBvfgYO5ARvq1tZ2kbW', '3', 'hazimi@gmail.com', '0126702994', 1, 2),
(8, 'suzan', '$2y$09$LVCp0pDQPwcweNGFIaQU9ew4PkdbVBcS8Rd8ydCAwJ4u1BB1EvV8K', '2', 'suzan@gmail.com', '0123343443', 1, 2),
(9, 'yingkang', '$2y$09$f2geRuKXdHgRW757VzvsBOTTtuxRCH1zOD3SpgF7zOFZQ/5Ktszla', '4', 'yingkang@gmail.com', '0125544545', 1, 2),
(22, 'miko', '$2y$09$QVLlQVh85rLfVRUZMTJOrODEPh2XM9IEtQYZGT1GfIxdqfVjJul7q', '1', 'miko@gmail.com', '60169682313', 1, 19),
(24, 'alex', '$2y$09$.Cxe62rjWe26qoGOso6.nu735ZyKWKXhIgbaarHOFCJ.F8VjjVtL2', '3', 'alex@gmail.com', '60124445433', 1, 19),
(25, 'wangxing', '$2y$09$17bB3jljYMymuRqxEJiuyOG3KLbbQqplYZTiJJrIIjZ1aN2F.QZh.', '2', 'wangxing@gmail.com', '601234334334', 1, 19),
(26, 'jiamei', '$2y$09$yMZYYwW1myA9zQxJ1LG/7udozUClgNMIyIeZytsLfko7Mt/9.7aQu', '4', 'jiamei@gmail.com', '60125544334', 1, 19),
(29, 'guagua', '$2y$09$73vrn0FjJQdBkVWmbDrX.OO7JC6qad0R01mSYZWFPg38WRQUbnGB.', '1', 'guagua@gmail.com', '6012445444', 1, 2),
(35, 'tk', '$2y$09$ZBiCq.Ijh4KA6RJMwuK6weBJXI/G4lTg.uK4VKJrq.NCsAhDeS8RC', '1', 'taykang1127@gmail.com', '01110216996', 1, 20),
(37, 'ahgan', '$2y$09$ZBiCq.Ijh4KA6RJMwuK6weBJXI/G4lTg.uK4VKJrq.NCsAhDeS8RC', '1', 'ahgan@gmail.com', '012333434', 1, 20),
(40, 'zhiqing', '$2y$09$T/84C6TWX/grW78ixzbpLePxJWbNw7Ehk6XFPC8Fi5U3W.CDjO8jG', '1', 'zhiqing@gmail.com', '601244454545', 1, 24),
(41, 'kay', '$2y$09$GHmny5GblkD8GZE6VyynpO4dY0MdcdTB7hbeGXBEvttY6sXqttY/S', '1', 'kayl8.tan@gmail.com', '0122321413', 1, 25),
(42, 'admin', '$2y$09$VIKeSSAnbd7yRVtKsciuQ.Aiz9kCf6PWoIbxgLfi9i0MVABFvitsG', '1', 'admin_jason@gmail.com', '6012345678', 1, 26),
(43, 'wh', '$2y$09$VTuGg8Gr.8/gNx9STu.yxuTfNG0ROLriy4Pp0mAf9z9k8WRlURCJ2', '1', 'changwh97@gmail.com', '601116203836', 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `merchant_id` int(11) NOT NULL,
  `merchant_name` varchar(255) DEFAULT NULL,
  `merchant_logo` varchar(255) DEFAULT NULL,
  `about_us` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `google_map` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `payment_apikey` varchar(255) DEFAULT NULL,
  `payment_category_code` varchar(255) DEFAULT NULL,
  `merchant_favicon_logo` varchar(255) DEFAULT NULL,
  `google_map_iframe` text DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `whatsapp_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `website_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`merchant_id`, `merchant_name`, `merchant_logo`, `about_us`, `address`, `google_map`, `email`, `phone_number`, `payment_apikey`, `payment_category_code`, `merchant_favicon_logo`, `google_map_iframe`, `facebook_link`, `whatsapp_link`, `instagram_link`, `website_link`) VALUES
(2, 'ThongHeng', '451225023_Black_Elegant_Modern_Name_Initials_Monogram_Logo__1_-removebg-preview.png', 'Welcome to Thong Heng Automotive Repair Shop! We are a trusted and reliable destination for all your vehicle repair needs. With years of experience in the industry, our skilled technicians are dedicated to providing top-notch service and ensuring your satisfaction', 'Thong Heng, 86200 Simpang Renggam', 'https://www.google.com/maps/dir//Thong+Heng+Simpang+Renggam+86200+Simpang+Renggam+Johor/@1.8246355,103.3129567,14z/data=!4m5!4m4!1m0!1m2!1m1!1s0x31d06300a5cc841f:0x51427b3c244813fb', 'thonghengmotor88@gmail.com', '60197114816', 'cTQzXYXBKHZGQQwP4XD/grvN6kMNlGP+pR90hobvvZCN2varp74uyHNotvz/adal', 'GzLPhDlx0rDd42njRgxrQg==', '641409658_Black Elegant Modern Name Initials Monogram Logo (1).png', '&lt;iframe src=\\&quot;https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7975.590473640601!2d103.31289232698734!3d1.824678393583197!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d06300a5cc841f%3A0x51427b3c244813fb!2sThong%20Heng!5e0!3m2!1sen!2smy!4v1687026002779!5m2!1sen!2smy\\&quot; width=\\&quot;600\\&quot; height=\\&quot;450\\&quot; style=\\&quot;border:0;\\&quot; allowfullscreen=\\&quot;\\&quot; loading=\\&quot;lazy\\&quot; referrerpolicy=\\&quot;no-referrer-when-downgrade\\&quot;&gt;&lt;/iframe&gt;', NULL, 'https://wa.me/60197114816', NULL, NULL),
(19, 'Beautiful_seol', 'beautifulsoul.png', 'Welcome to Beautiful Soul! We are your ultimate destination for all things girl-related. We believe in empowering girls to embrace their unique beauty and express themselves confidently.', 'Beautiful_seol, Muar, Johor.', 'https://goo.gl/maps/7k7oGyumXcDBxMj69', 'miko@gmail.com', '60169682313', 'J77CiMqSYEb572WKWC/KRor8G4oC8m5HKoS+jUYEqaQdmf5JxmW6A0VJ/zECC6z2', 'Gx0wslgLY63sfsk9K5jG9A==', 'beautifulsoul_favico.png', '&lt;iframe src=\\&quot;https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7974.662843598885!2d102.56824328465821!3d2.0230781758835894!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1b90fcb521ccd%3A0x3a3fa2be7e781a77!2sGlory%20Collection!5e0!3m2!1sen!2smy!4v1687025568124!5m2!1sen!2smy\\&quot; width=\\&quot;600\\&quot; height=\\&quot;450\\&quot; style=\\&quot;border:0;\\&quot; allowfullscreen=\\&quot;\\&quot; loading=\\&quot;lazy\\&quot; referrerpolicy=\\&quot;no-referrer-when-downgrade\\&quot;&gt;&lt;/iframe&gt;', NULL, 'https://wa.me/60169682313', NULL, NULL),
(20, 'EZY_HAIR_STUDIO', 'favicon.png', 'Ezy Hair Studio offers top notch professional hair services that is friendly, trendy and in touch with the latest fashion styles. The experienced team here will surely impress you with their professionalism and awesome service.', 'No.31, Ground Floor Jalan Pelangi, Pusat Perniagaan Pelangi, 86200 Simpang Renggam, Johor.', 'https://goo.gl/maps/fnYwTm5gmTHRyFXc8', 'taykang1127@gmail.com', '01110216996', 'dOoK7L/FAJeFdpx6RT9/KQ==', 'dOoK7L/FAJeFdpx6RT9/KQ==', 'favicon.png', '&lt;iframe src=\\&quot;https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1993.8944110681632!2d103.3061257406916!3d1.827569144887629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smy!4v1688101472255!5m2!1sen!2smy\\&quot; width=\\&quot;600\\&quot; height=\\&quot;450\\&quot; style=\\&quot;border:0;\\&quot; allowfullscreen=\\&quot;\\&quot; loading=\\&quot;lazy\\&quot; referrerpolicy=\\&quot;no-referrer-when-downgrade\\&quot;&gt;&lt;/iframe&gt;', NULL, 'wa.link/k4vplk', 'https://instagram.com/ezy_6_studio?igshid=NTc4MTIwNjQ2YQ==', NULL),
(24, 'U_Toys_N_Gifts', 'logo_U_Toys_N_Gifts.png', 'Welcome to U Toys N Gifts, your premier toy store in Batu Pahat! We offer a wide selection of high-quality toys and gifts for kids of all ages. Our knowledgeable and friendly team is here to help you find the perfect toy for any occasion. Come and discover the magic of play at U Toys N Gifts!', 'G10 Ground Floor, Square One Mall, Taman Flora Utama 83000, Batu Pahat,Johor.', 'https://goo.gl/maps/vadQBBgb7jjzKeyd9', 'zhiqing@gmail.com', '601244454545', 'dOoK7L/FAJeFdpx6RT9/KQ==', 'dOoK7L/FAJeFdpx6RT9/KQ==', 'logo_U_Toys_N_Gifts.png', '&lt;iframe src=\\&quot;https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31901.646414830135!2d102.94627885459134!3d1.8645777341592493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d050d6ac758c07%3A0xa4154d0e7785da16!2sSquare%20One%20Shopping%20Mall!5e0!3m2!1sen!2smy!4v1688131953895!5m2!1sen!2smy\\&quot; width=\\&quot;600\\&quot; height=\\&quot;450\\&quot; style=\\&quot;border:0;\\&quot; allowfullscreen=\\&quot;\\&quot; loading=\\&quot;lazy\\&quot; referrerpolicy=\\&quot;no-referrer-when-downgrade\\&quot;&gt;&lt;/iframe&gt;', NULL, NULL, NULL, NULL),
(26, 'your_merchant_name', 'default-logo.png', 'welcome to your_merchant ...', 'G10 Ground Floor, Square One Mall, Taman Flora Utama 83000, Batu Pahat,Johor.', 'https://goo.gl/maps/EdoYVyKN2Afxs3XXA', 'admin_jason@gmail.com', '6012345678', 'eGA86WcdkoOlddm6K7/UdHNReoIdG+OVOzwjlkcmphvpBIlED5ZutKHRFHP/57vZ', 'injDb18/9kRQB8D4foFHBQ==', 'default-logo.png', '&lt;iframe src=\\&quot;https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127606.95133555272!2d102.96228328745019!3d1.8595273615749437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d050d6ac758c07%3A0xa4154d0e7785da16!2sSquare%20One%20Shopping%20Mall!5e0!3m2!1sen!2smy!4v1688747727981!5m2!1sen!2smy\\&quot; width=\\&quot;600\\&quot; height=\\&quot;450\\&quot; style=\\&quot;border:0;\\&quot; allowfullscreen=\\&quot;\\&quot; loading=\\&quot;lazy\\&quot; referrerpolicy=\\&quot;no-referrer-when-downgrade\\&quot;&gt;&lt;/iframe&gt;', NULL, 'https://api.whatsapp.com/send/?phone=60197114816&text&type=phone_number&app_absent=0', NULL, NULL),
(27, 'WeiHong', 'BLOG-23-L-3.jpg', 'Yes', 'Yes', 'https://goo.gl/maps/aC1R3RRwDpdLysEQA', 'changwh97@gmail.com', '601116203836', 'dOoK7L/FAJeFdpx6RT9/KQ==', 'dOoK7L/FAJeFdpx6RT9/KQ==', 'BLOG-23-L-3.jpg', '&lt;iframe src=\\&quot;https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31901.58465623883!2d102.95794056720491!3d1.8679818128346908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d050b1a53f27bd%3A0x14edba3f60bbadd3!2sWatsons%20Batu%20Pahat%20Mall%20(Pharmacy)!5e0!3m2!1sen!2smy!4v1688839879795!5m2!1sen!2smy\\&quot; width=\\&quot;600\\&quot; height=\\&quot;450\\&quot; style=\\&quot;border:0;\\&quot; allowfullscreen=\\&quot;\\&quot; loading=\\&quot;lazy\\&quot; referrerpolicy=\\&quot;no-referrer-when-downgrade\\&quot;&gt;&lt;/iframe&gt;', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT '',
  `payment_type` varchar(20) DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `order_status` int(11) DEFAULT NULL,
  `txnid` varchar(200) DEFAULT NULL,
  `billcode` varchar(200) DEFAULT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_value` varchar(50) DEFAULT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `added_on` datetime DEFAULT NULL,
  `order_id` varchar(255) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `phone_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user_id`, `address`, `city`, `pincode`, `payment_type`, `total_price`, `payment_status`, `order_status`, `txnid`, `billcode`, `coupon_id`, `coupon_value`, `coupon_code`, `added_on`, `order_id`, `merchant_id`, `phone_number`) VALUES
(180, '63lEWX1XoSPuo1msYDb4M1MSJIC2', '11, TAMAN WARISAN', 'MUAR, JOHOR', '84000', 'COD', 287.1, 'Paid', 5, '12be6a5b1edd024644b1', 'null', 12, '31.9', '0', '2023-06-01 07:38:24', '820230701073824', 2, '601244848554'),
(181, '63lEWX1XoSPuo1msYDb4M1MSJIC2', '11, TAMAN WARISAN', 'MUAR, JOHOR', '84000', 'Online Banking', 607.5, 'Paid', 5, 'TP189942475463619010723', 'kvpnyif4', 12, '67.5', '0', '2023-07-01 07:40:20', '420230701074020', 2, '601244848554'),
(182, '63lEWX1XoSPuo1msYDb4M1MSJIC2', '11, TAMAN WARISAN', 'MUAR, JOHOR', '84000', 'COD', 957, 'Paid', 5, 'da93ccdcc4f9730dbbc5', 'null', 0, '', '0', '2023-07-01 07:46:16', '320230701074616', 2, '601244848554'),
(183, '63lEWX1XoSPuo1msYDb4M1MSJIC2', '11, TAMAN WARISAN', 'MUAR, JOHOR', '84000', 'Online Banking', 287.1, 'Paid', 3, 'TP189963364012620010723', '3yccvvd2', 12, '31.9', '0', '2023-07-01 08:29:35', '820230701082935', 2, '601244848554'),
(184, '63lEWX1XoSPuo1msYDb4M1MSJIC2', '11, TAMAN WARISAN', 'MUAR, JOHOR', '84000', 'COD', 637, 'Paid', 5, 'bece0f8c3026ffebad9e', 'null', 0, '', '0', '2023-07-02 12:14:34', '320230702121434', 2, '601244848554'),
(185, '63lEWX1XoSPuo1msYDb4M1MSJIC2', '11, TAMAN WARISAN', 'MUAR, JOHOR', '84000', 'Online Banking', 573.3, 'Pending', 1, '38a9d9bbe40a0771c503', 'null', 12, '63.7', '0', '2023-07-02 03:57:21', '920230702035721', 2, '601244848554'),
(186, '63lEWX1XoSPuo1msYDb4M1MSJIC2', '11, TAMAN WARISAN', 'MUAR, JOHOR', '84000', 'Online Banking', 637, 'Paid', 5, 'TP190057452335503020723', '9zqaebxo', 0, '', '0', '2023-07-02 03:59:07', '820230702035907', 2, '601244848554'),
(187, '63lEWX1XoSPuo1msYDb4M1MSJIC2', '21, TAMAN WARISAN', 'MUAR, JOHOR', '84000', 'Online Banking', 287.1, 'Paid', 5, 'TP190069236424809020723', 'hr454yxn', 12, '31.9', '0', '2023-07-02 09:52:17', '320230702095217', 2, '601244848554');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `qty`, `price`, `merchant_id`) VALUES
(255, '820230701073824', 25, 1, 319, 2),
(256, '420230701074020', 26, 3, 225, 2),
(257, '320230701074616', 25, 3, 319, 2),
(258, '820230701082935', 25, 1, 319, 2),
(259, '320230702121434', 25, 1, 319, 2),
(260, '320230702121434', 24, 1, 318, 2),
(261, '920230702035721', 25, 1, 319, 2),
(262, '920230702035721', 24, 1, 318, 2),
(263, '820230702035907', 25, 1, 319, 2),
(264, '820230702035907', 24, 1, 318, 2),
(265, '320230702095217', 25, 1, 319, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(3, 'Shipped'),
(4, 'Canceled'),
(5, 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mrp` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `short_desc` varchar(2000) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `best_seller` int(11) DEFAULT NULL,
  `meta_title` varchar(2000) DEFAULT NULL,
  `meta_desc` varchar(2000) DEFAULT NULL,
  `meta_keyword` varchar(2000) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `sales_qty` int(11) DEFAULT NULL,
  `pending_qty` int(11) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `categories_id`, `sub_categories_id`, `name`, `mrp`, `price`, `qty`, `image`, `short_desc`, `description`, `best_seller`, `meta_title`, `meta_desc`, `meta_keyword`, `added_by`, `status`, `sales_qty`, `pending_qty`, `merchant_id`) VALUES
(22, 17, 0, 'CASTROL EDGE 10W-60', 250, 220, 100, '321211405_Product-1-28-1639382732.jpg', 'CASTROL EDGE IS 3X STRONGER THAN THE LEADING FULL SYNTHETIC AGAINST VISCOSITY BREAKDOWN', 'CASTROL EDGE IS 3X STRONGER THAN THE LEADING FULL\\r\\nSYNTHETIC AGAINST VISCOSITY BREAKDOWN MEETS OR EXCEEDS INDUSTRY STANDARDS: ACEA A3/B3, A3/B4 API SN/CF', 0, 'CASTROL EDGE 10W-60', 'CASTROL EDGE 10W-60', 'CASTROL EDGE 10W-60', 7, 1, 0, 0, 2),
(23, 17, 0, 'CASTROL EDGE 5W-40', 200, 170, 100, '480423336_Product-1-27-1639382721.jpg', 'The ultimate motor oil for high-performance engines. Engineered with advanced technology, this premium synthetic oil provides superior protection and performance.', 'Upgrade your engine\\\'s performance with Castrol EDGE 5W-40 and unleash the full potential of your vehicle. Get the confidence to push your engine to its limits with Castrol, a name synonymous with excellence in lubrication technology.', 0, 'CASTROL EDGE 5W-40', 'The ultimate motor oil for high-performance engines. Engineered with advanced technology, this premium synthetic oil provides superior protection and performance.', 'CASTROL EDGE 5W-40', 7, 1, 0, 0, 2),
(24, 17, 0, 'CASTROL EDGE 5W-30 C3', 400, 318, 98, '380400396_Product-1-26-1639382708.jpg', 'The ultimate motor oil for modern engines. This advanced synthetic oil is specially formulated to meet the strict requirements of modern vehicles, providing superior performance and protection.', 'Castrol EDGE 5W-30 C3 is engineered with Fluid TITANIUM technology, offering unrivaled strength to keep your engine running smoothly. It provides exceptional lubrication even under extreme temperatures and pressures, reducing friction and maximizing fuel efficiency.', 0, 'CASTROL EDGE 5W-30 C3', 'The ultimate motor oil for modern engines. This advanced synthetic oil is specially formulated to meet the strict requirements of modern vehicles, providing superior performance and protection.', 'CASTROL EDGE 5W-30 C3', 7, 1, 2, 1, 2),
(25, 14, 11, 'CAMEL DIN62', 400, 319, 91, '281071279_Product-2-15-1639380423.png', 'Experience reliable and long-lasting power for your vehicle with the Camel DIN62 car battery.', 'With its robust construction and advanced technology, the Camel DIN62 battery delivers reliable starting power in various weather conditions.\\r\\nWhether you\\\'re facing extreme temperatures or challenging driving conditions, you can trust this battery to provide a consistent and dependable performance.', 1, 'CAMEL DIN62', 'Experience reliable and long-lasting power for your vehicle with the Camel DIN62 car battery.', 'CAMEL DIN62', 7, 1, 9, 0, 2),
(26, 14, 10, 'AMARON NS60', 300, 225, 97, '671525861_Product-2-7-1639377914.png', 'Power up your vehicle with the reliable and high-performance Amaron NS60 car battery. Engineered with cutting-edge technology, this maintenance-free battery ensures a dependable and long-lasting power supply.', 'The Amaron NS60 battery is designed to deliver consistent starting power, even in extreme weather conditions. It provides reliable performance, allowing your vehicle to start smoothly every time, whether it\\\\\\\'s freezing cold or scorching hot outside.', 1, 'AMARON NS60', 'The Amaron NS60 battery is designed to deliver consistent starting power, even in extreme weather conditions. It provides reliable performance, allowing your vehicle to start smoothly every time, whether it\\\\\\\'s freezing cold or scorching hot outside.', 'AMARON NS60', 7, 1, 3, 0, 2),
(27, 14, 11, 'CAMEL Q85 (EFB)123', 500, 429, 100, '857503284_Product-1-13-1639319037.png', 'Experience exceptional performance and reliability with the Camel Q85 (EFB) car battery.', 'The Camel Q85 (EFB) battery offers advanced cycling capabilities, making it ideal for vehicles that frequently start and stop their engines. It provides reliable power for seamless engine restarts and ensures consistent performance even in heavy traffic conditions.', 0, 'CAMEL Q85 (EFB)', 'Experience exceptional performance and reliability with the Camel Q85 (EFB) car battery.', 'CAMEL Q85 (EFB)', 7, 1, 0, 0, 2),
(28, 18, 0, 'NEW Magic Cushion SPF50+ PA+++', 50, 40, 100, '892044173_3c85a8269b5e13188dc046f9cbaab44a.jpeg', 'Plant extracts (Calendula flower extract, Eucalyptus pitcher leaf extract, Peppermint extract)', 'Magic fit powder gives light fitting for more application gives skin flaws delicate coverage.\\r\\n\\r\\nGives fresh makeup for long without darkening for clear looking skin.\\r\\n\\r\\nPlant extract supply fresh moisture for non drying soft skin look. \\r\\n\\r\\n\\r\\nHow to use\\r\\nUse proper amount on puff to apply and pat gently onto face to finish.', 1, 'NEW Magic Cushion SPF50+ PA+++', 'Plant extracts (Calendula flower extract, Eucalyptus pitcher leaf extract, Peppermint extract)', 'NEW Magic Cushion SPF50+ PA+++', 22, 1, 0, 0, 19),
(29, 18, 0, 'M Perfect Cover BB Cream SPF 42PA+++', 55, 44, 100, '841332905_c02761d01cc9e1b7ad64bc63c4da378d.jpeg', 'It is a multi function BB Cream with effect of UV blocking, whitening and wrinkle care, creating perfect cover makeup.', 'This M Perfect Cover BB Cream makes your skin tone clean and natural by concealing blemishes with exellent skin coverage. It is a multi functional makeup cream with blocking UV rays, whitening and wrinkle care effects and simplifies makeup formalities. Its moisturized application with W/S texture makes sleek skin tone while supplying moisture and nutrition at the same time.\\r\\n\\r\\nIt provides excellently concealing any types of pigmentation or discoloration area on face including acne, couperose, vitiligo, age spots, sun spots and dark circles.\\r\\n- For all skin type even for acne skin type\\r\\n- It can be used as a makeup base or foundation.\\r\\n- Containing substances for Soothing the skin (Na-complex)', 1, 'M Perfect Cover BB Cream SPF 42PA+++', 'It is a multi function BB Cream with effect of UV blocking, whitening and wrinkle care, creating perfect cover makeup.', 'M Perfect Cover BB Cream SPF 42PA+++', 22, 1, 0, 0, 19),
(30, 18, 0, 'Ready Stock Missha: The Style 4D Mascara 7g', 25, 20, 100, '569383849_7d52f582d030b036e85fb1dc06c834d7.jpeg', 'A large amount of vegetable wax blend gives a soft, voluminous lashes not gonna rake it self. Ingredients for vegetable use relieves irritation to the delicate eye area does not penetrate well.', 'Description\\r\\nA large amount of vegetable wax blend gives a soft,\\r\\nvoluminous lashes not gonna rake it self.\\r\\nIngredients for vegetable use relieves irritation\\r\\nto the delicate eye area does not penetrate well.\\r\\n\\r\\nHow to use\\r\\nUsing the mascara brush, brush outwards\\r\\nfrom the roots to the tips of your eyelashes, with zigzag strokes.', 1, 'Ready Stock Missha: The Style 4D Mascara 7g', 'A large amount of vegetable wax blend gives a soft, voluminous lashes not gonna rake it self. Ingredients for vegetable use relieves irritation to the delicate eye area does not penetrate well.', 'Ready Stock Missha: The Style 4D Mascara 7g', 22, 1, 0, 0, 19),
(31, 20, 0, 'Water Sleeping Mask [Mini Size] 15ml / 3g', 30, 25, 100, '643999191_93fef5e9723b5863c3f2bfadbae85a1a.jpeg', 'This sample-size version of Laneige\\\'s bestselling Water Sleeping Mask gives you a sneak preview of its super hydrating benefits. Laneige-exclusive Sleeptox™ restores skin\\\'s optimal moisture levels overnight while its signature MoistureWrap™ contains hydro ion mineral water, hunza apricot and evening primrose root extracts that wrap skin in a breathable moisture layer. Finally, the Sleepscent™ containing orange flower, ylang-ylang and sandalwood oil scents helps relax your mind and body and promotes a rejuvenating sleep.', 'Laneige - Water Sleeping Mask 15ml\\r\\nThis sample-size version of Laneige\\\'s bestselling Water Sleeping Mask gives you a sneak preview of its super hydrating benefits. Laneige-exclusive Sleeptox™ restores skin\\\'s optimal moisture levels overnight while its signature MoistureWrap™ contains hydro ion mineral water, hunza apricot and evening primrose root extracts that wrap skin in a breathable moisture layer. Finally, the Sleepscent™ containing orange flower, ylang-ylang and sandalwood oil scents helps relax your mind and body and promotes a rejuvenating sleep.\\r\\n\\r\\nSoothes stressed skin, hydrates dry skin, and removes dead skin cells leaving skin soft and smooth.\\r\\n\\r\\nHow to use: \\r\\n1. After washing your face, take an appropriate amount and gently apply from inside to outside along the skin texture\\r\\n2. Go to sleep after the product is absorbed without rinsing off.\\r\\n\\r\\nLANEIGE Water Sleeping Mask 15ml (Lavender)\\r\\n1. Skin purification during sleep – Moisture sleeping care\\r\\n2. Best Sleeping Beauty care for good morning skin!\\r\\n3. Moisturize and revitalize skin as if having had a good night’s sleep with special intensive care during sleep.\\r\\n4. Experience good morning skin!', 1, 'Water Sleeping Mask [Mini Size] 15ml / 3g', 'This sample-size version of Laneige\\\'s bestselling Water Sleeping Mask gives you a sneak preview of its super hydrating benefits. Laneige-exclusive Sleeptox™ restores skin\\\'s optimal moisture levels overnight while its signature MoistureWrap™ contains hydro ion mineral water, hunza apricot and evening primrose root extracts that wrap skin in a breathable moisture layer. Finally, the Sleepscent™ containing orange flower, ylang-ylang and sandalwood oil scents helps relax your mind and body and promotes a rejuvenating sleep.', 'Water Sleeping Mask [Mini Size] 15ml / 3g', 22, 1, 0, 0, 19),
(32, 20, 0, 'ETUDE HOUSE  Moistfull Collagen Skin Care Kit [4 items]', 50, 40, 100, '960610430_421a597a5261d3f6d121b38da270b78c.jpeg', 'The small particles of the Super collagen water (Hydrolyzed Collagen) and Baobab oil (Adansonia digitata Fruit extract) in the moistfull Collagen 4-piece skin kit endlessly pro- vide moisture and leave yourskin feeling bouncy like jelly.', 'ETUDE HOUSE Moistfull Collagen Skin Care Kit [4 items] \\r\\n\\r\\n??ORIGINAL ????\\r\\n\\r\\nThe small particles of the Super collagen water (Hydrolyzed Collagen) and Baobab oil (Adansonia digitata Fruit extract) in the moistfull Collagen 4-piece skin kit endlessly pro- vide moisture and leave yourskin feeling bouncy like jelly. \\r\\n\\r\\nThis kit contains \\r\\nMoistfull Collagen Facial Toner 20ml Moistfull Collagen Emulsion 20ml+ Moistfull Col- lagen Essence 15ml Moist Collagen Cream 10ml', 1, 'ETUDE HOUSE  Moistfull Collagen Skin Care Kit [4 items]', 'The small particles of the Super collagen water (Hydrolyzed Collagen) and Baobab oil (Adansonia digitata Fruit extract) in the moistfull Collagen 4-piece skin kit endlessly pro- vide moisture and leave yourskin feeling bouncy like jelly.', 'ETUDE HOUSE  Moistfull Collagen Skin Care Kit [4 items]', 22, 1, 0, 0, 19),
(33, 19, 0, 'Mise En Scene  New Perfect Serum (80ml) 5 Types', 50, 34, 100, '264182085_379c8c788c9ef1e96016fae9b8a909a3.jpeg', 'The new concept serum for damage care and styling.', 'The new concept serum for damage care and styling.\\r\\nStyling with heating tools, such as hairdryer and curling iron lasts for whole day.\\r\\nMise En Scene Perfect Serum Rich gives healthy care for damaged hair caused by bleaching and dying. This serum gives volume and shine and cares for hair elasticity while moisturizing hair.  \\r\\nAslick and natural styling with the serum effect. \\r\\n\\r\\nOption \\r\\n1. Original 80ml\\r\\nEnriched serum for damage hair\\r\\n\\r\\n2. Styling Serum 80ml \\r\\nDamage care & keep styling\\r\\n\\r\\n3. Rose Edition 80ml \\r\\nMUSK scent serum, Intensive hair care effect \\r\\n\\r\\n 4. Coco Water 80ml\\r\\nHair Moisturizing Charge\\r\\n\\r\\n5 .Rich 80ml\\r\\nVolume and shine', 0, 'Mise En Scene  New Perfect Serum (80ml) 5 Types', 'The new concept serum for damage care and styling.', 'Mise En Scene  New Perfect Serum (80ml) 5 Types', 22, 1, 0, 0, 19),
(41, 33, 0, 'Man cut (exp: 30/6/2023)', 30, 15, 100, '500090557_cut.jpg', 'This service only available for 30/6/2023.', 'Man cut. It only available for 30/6/2023. If expired, please contact admin.', 1, 'Man cut', 'Man cut', 'Man cut', 35, 1, 0, 0, 20),
(42, 33, 0, 'Woman cut (EXP: 30/6/2023)', 355, 20, 100, '178024818_aaaaa.png', 'This service only available for 30/6/2023.', 'Women cut. It only available for 30/6/2023. If expired, please contact admin.', 1, 'Women cut', 'Women cut', 'Women cut', 35, 1, 0, 0, 20),
(45, 26, 0, 'Toys Truck For Boys Garage Car Truck', 30, 23, 100, '111274711_TOY BOY.jpeg', 'Toys Truck For Boys Garage Car Truck with Cars Mcqueen Hotwheels DieCast Model mainan budak lelaki', 'Toys Truck For Boys Garage Car Truck with Cars Mcqueen Hotwheels DieCast Model mainan budak lelaki', 0, 'Toys Truck For Boys Garage Car Truck', 'Toys Truck For Boys Garage Car Truck with Cars Mcqueen Hotwheels DieCast Model mainan budak lelaki', 'Toys Truck For Boys Garage Car Truck', 40, 1, 0, 0, 24);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_images` varchar(250) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `product_images`, `merchant_id`) VALUES
(1, 8, '479197953_526258680_Floral-Print-Polo-T-shirt1.jpg', 2),
(2, 8, '301120849_309027777_Floral-Print-Polo-T-shirt.jpg', 2),
(5, 10, '530695131_309027777_Floral-Print-Polo-T-shirt.jpg', 2),
(8, 22, '391912310_Product-2-28-1639382732.jpg', 2),
(9, 23, '378021915_Product-2-27-1639382721.jpg', 2),
(10, 24, '770822372_Product-2-26-1639382708.jpg', 2),
(11, 25, '752540668_Product-1-15-1639319187.png', 2),
(12, 26, '213294736_Product-1-7-1639318324.png', 2),
(13, 28, '742889035_b2c5bca6f993ee57d0418c6e2815e74e.jpeg', 19),
(14, 28, '624212200_af3541ea57eb27ac0f5e7643e1a0465c.jpeg', 19),
(15, 29, '738032372_af8fb4aeb6eeacb93c90b65127070733.jpeg', 19),
(16, 29, '677290336_e65864ed3e96d7926ac1ab7482ccdf9b.jpeg', 19),
(17, 30, '232905640_688c5382a1c462719b83f8ea9411c131.jpeg', 19),
(18, 30, '796577675_3eb36b33718003eec330e03987d1c0b6.jpeg', 19),
(19, 31, '385644870_a6fe95c37aa6820dcf00cab0b8633a2a.jpeg', 19),
(20, 33, '561754680_9adbfd370b2bc00ea9a5c820b9acfe21.jpeg', 19),
(24, 45, '298001718_toyboy3.jpeg', 24);

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `rating` varchar(20) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `added_on` datetime DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`id`, `product_id`, `user_id`, `rating`, `review`, `status`, `added_on`, `merchant_id`) VALUES
(31, 26, '63lEWX1XoSPuo1msYDb4M1MSJIC2', 'Fantastic', 'GOOD PRODUCT', 1, '2023-07-01 08:04:34', 2),
(33, 25, '63lEWX1XoSPuo1msYDb4M1MSJIC2', 'Good', 'good', 1, '2023-07-02 09:54:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `role_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`, `role_description`) VALUES
(1, 'Administrator', 'Access to all fucntions'),
(2, 'Product Manager', 'Access to product management'),
(3, 'HR Manager', 'Access to employees management'),
(4, 'Sales Manager', 'Access to sales management');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `categories_id`, `sub_categories`, `status`, `merchant_id`) VALUES
(10, 14, 'AMERON', 1, 2),
(11, 14, 'CAMEL', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `added_on` datetime NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `stateNcity` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `added_on`, `profile_image`, `uid`, `merchant_id`, `address`, `stateNcity`, `postcode`) VALUES
(54, 'KUAN JIUN YING', 'jiunying2000kjy@gmail.com', '60182310905', '2023-06-10 05:11:52', '20230610_KUAN JIUN YING.jpg', '63lEWX1XoSPuo1msYDb4M1MSJIC2', 19, '', '', ''),
(55, 'Kuan Silent', 'silentkuan@gmail.com', '601823323333', '2023-06-10 07:28:23', '20230616_3135715.png', 'Gq5joGpbLDQKcllnLpuouUgwfnd2', 2, '10, Taman Mawar', 'Muar, Johor.', '84000'),
(56, 'KUAN JIUN YING', 'jiunying2000kjy@gmail.com', '601244848554', '2023-06-10 05:32:21', '20230629_PROFILEPIC_KJY.jpg', '63lEWX1XoSPuo1msYDb4M1MSJIC2', 2, '11, TAMAN WARISAN', 'MUAR, JOHOR', '84000'),
(57, 'miren shen', 'shenmiren151@gmail.com', '60182355555', '2023-06-11 02:53:35', '20230611_miren shen.jpg', 'Nv6bJkITkvW8KLcHp5UC8M8subS2', 19, '', '', ''),
(58, 'Gan QX', 'qingxianggan1757@gmail.com', '0197114816', '2023-06-11 02:58:10', '20230611_Gan QX.jpg', 'IhQxnjZgOEW6ivXkrPwvV5ZrLm93', 19, '', '', ''),
(60, 'Serena', 'eekee00@gmail.com', '60177325055', '2023-06-11 03:53:38', 'null', 'jfZt0SrczxfUpYePJhjbSWkpUcB2', 19, '', '', ''),
(61, 'Serena Tee', 'eekee00@gmail.com', '0177325055', '2023-06-11 04:01:22', '20230611_Serena Tee.jpg', 'i4YGizSerOXnU9ETHXU241XGm4A3', 19, '', '', ''),
(62, 'OWEN', 'oteewen@gmail.com', '6012444554', '2023-06-12 03:58:55', '20230612_OWEN.jpg', '2mILa2hhjBUcqWLLMKH0kyDeZac2', 19, '', '', ''),
(63, 'Wang Xing ER', 'yamamoto.exw@gmail.com', 'null', '2023-06-15 01:49:10', '20230615_Wang Xing ER.jpg', 'dLNt7xi8vLhEdllmGid7UrzFQLy2', 2, NULL, NULL, NULL),
(64, 'Silent', 'silent@gmail.com', '60182310905', '2023-06-16 05:03:12', '20230617_3135715.png', 'MkEzyTj4S7h0LcrvS5GdzXqdH6H3', 2, '11, TAMAN MEWAH', 'BATU PAHAT, JOHOR.', '83000'),
(65, 'Kuan Silent', 'silentkuan12@gmail.com', '012333334', '2023-06-16 06:22:51', '20230617_3135715.png', 'Gq5joGpbLDQKcllnLpuouUgwfnd2', 24, 'a', 'a', 'a'),
(69, '123', '123@gmail.com', '01232234554', '2023-06-30 05:21:03', '20230630_atomy.png', '8SB47sfTsTXUuCWWShkAYgdTPdB2', 19, NULL, NULL, NULL),
(70, 'Gan QX', 'qingxianggan1757@gmail.com', '11212', '2023-06-30 05:41:36', '20230630_Gan QX.jpg', 'IhQxnjZgOEW6ivXkrPwvV5ZrLm93', 20, NULL, NULL, NULL),
(71, 'KUAN JIUN YING', 'jiunying2000kjy@gmail.com', '60123334334', '2023-06-30 06:03:59', '20230630_KUAN JIUN YING.jpg', '63lEWX1XoSPuo1msYDb4M1MSJIC2', 20, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `merchant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `added_on`, `merchant_id`) VALUES
(72, '63lEWX1XoSPuo1msYDb4M1MSJIC2', 25, '2023-07-01 06:48:30', 2),
(73, '63lEWX1XoSPuo1msYDb4M1MSJIC2', 24, '2023-07-01 06:48:32', 2),
(74, '63lEWX1XoSPuo1msYDb4M1MSJIC2', 26, '2023-07-01 07:56:33', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_master`
--
ALTER TABLE `coupon_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`merchant_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `coupon_master`
--
ALTER TABLE `coupon_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `merchant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
