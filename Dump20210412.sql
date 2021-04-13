--
-- Current Database: `sage_loja`
--


DROP TABLE IF EXISTS `brands`;

CREATE TABLE `brands` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `brands` WRITE;

INSERT INTO `brands` VALUES (1,'LG'),(2,'Samsung'),(3,'AOC'),(4,'Apple');

UNLOCK TABLES;

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sub` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;

INSERT INTO `categories` VALUES (6,NULL,'Monitor'),(14,NULL,'Som'),(15,14,'Headphones'),(16,14,'Microfones'),(17,15,'Com Fio'),(18,15,'Sem Fio');

UNLOCK TABLES;

DROP TABLE IF EXISTS `coupons`;

CREATE TABLE `coupons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `coupon_type` int(11) NOT NULL,
  `coupon_value` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



LOCK TABLES `coupons` WRITE;

UNLOCK TABLES;

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `options` WRITE;

INSERT INTO `options` VALUES (1,'Cor'),(2,'Tamanho'),(3,'Memória RAM'),(4,'Polegadas');

UNLOCK TABLES;


DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


LOCK TABLES `pages` WRITE;

UNLOCK TABLES;

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `id_brand` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `price` float NOT NULL,
  `price_from` float NOT NULL,
  `rating` float NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `sale` tinyint(1) NOT NULL,
  `bestseller` tinyint(1) NOT NULL,
  `new_product` tinyint(1) NOT NULL,
  `options` varchar(200) DEFAULT NULL,
  `peso` float NOT NULL,
  `altura` float NOT NULL,
  `comprimento` float NOT NULL,
  `diametro` float NOT NULL,
  `largura` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;

INSERT INTO `products` VALUES (1,6,1,'Monitor 21 polegadas','Alguma descrição do produto.',10,499,599,0,0,1,1,0,'1,2,4',0.9,20,15,20,15),(2,6,2,'Monitor 18 polegadas','Alguma outra descrição',10,399,999,2,0,1,1,0,'1,2',0.8,20,15,20,15),(3,6,2,'Monitor 19 polegadas','Alguma outra descrição',10,599,699,0,1,1,0,1,'1,2',0.7,20,15,20,15),(4,6,3,'Monitor 17 polegadas','Alguma outra descrição',10,3779,900,2,0,0,0,0,'1,4',0.6,20,15,20,14),(5,6,1,'Monitor 20 polegadas','Alguma outra descrição',10,299,499,0,1,0,0,1,'1',0.5,20,15,20,15),(6,6,3,'Monitor 20 polegadas','Alguma outra descrição',10,699,0,0,1,0,0,0,'1,2,4',0.4,20,15,20,15),(7,6,3,'Monitor 19 polegadas','Alguma outra descrição',10,889,999,5,1,0,0,0,'2,4',0.2,20,15,20,15),(8,6,1,'Monitor 18 polegadas','Alguma outra descrição',10,599,699,0,1,0,0,0,'4',0.3,20,15,20,15);

UNLOCK TABLES;


DROP TABLE IF EXISTS `products_images`;

CREATE TABLE `products_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `url` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;


LOCK TABLES `products_images` WRITE;

INSERT INTO `products_images` VALUES (1,1,'1.jpg'),(2,2,'2.jpg'),(3,3,'3.jpg'),(4,4,'4.jpg'),(5,5,'1.jpg'),(6,6,'3.jpg'),(7,7,'7.jpg'),(8,8,'7.jpg'),(9,2,'4.jpg'),(10,2,'7.jpg'),(11,2,'4.jpg');

UNLOCK TABLES;

DROP TABLE IF EXISTS `products_options`;

CREATE TABLE `products_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `p_value` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

LOCK TABLES `products_options` WRITE;

INSERT INTO `products_options` VALUES (1,1,1,'Azul'),(2,1,2,'23cm'),(3,1,4,'21'),(4,2,1,'Azul'),(5,2,2,'19cm'),(6,3,1,'Vermelho'),(7,3,2,'19cm');

UNLOCK TABLES;

DROP TABLE IF EXISTS `purchase_transactions`;

CREATE TABLE `purchase_transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_purchase` int(11) NOT NULL,
  `amount` float NOT NULL,
  `transaction_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



LOCK TABLES `purchase_transactions` WRITE;

UNLOCK TABLES;

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_coupon` int(11) DEFAULT NULL,
  `total_amount` float NOT NULL,
  `payment_type` varchar(100) DEFAULT NULL,
  `payment_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;



LOCK TABLES `purchases` WRITE;

INSERT INTO `purchases` VALUES (1,2,NULL,599,'pagseguro_t',1),(2,2,NULL,599,'pagseguro_t',1),(3,2,NULL,599,'pagseguro_t',1),(4,2,NULL,599,'pagseguro_t',1),(5,2,NULL,599,'pagseguro_t',1),(6,2,NULL,599,'pagseguro_t',1),(7,2,NULL,599,'pagseguro_t',1),(8,2,NULL,599,'pagseguro_t',1),(9,2,NULL,599,'pagseguro_t',1),(10,2,NULL,599,'pagseguro_t',1),(11,2,NULL,599,'pagseguro_t',1),(12,2,NULL,599,'pagseguro_t',1),(13,2,NULL,599,'pagseguro_t',1),(14,2,NULL,599,'pagseguro_t',1),(15,2,NULL,599,'pagseguro_t',1),(16,2,NULL,599,'pagseguro_t',1),(17,2,NULL,599,'pagseguro_t',1),(18,2,NULL,599,'pagseguro_t',1),(19,2,NULL,599,'pagseguro_t',1),(20,2,NULL,599,'pagseguro_t',1),(21,2,NULL,599,'pagseguro_t',1),(22,2,NULL,1198,'pagseguro_t',1),(23,2,NULL,1198,'pagseguro_t',1),(24,2,NULL,1198,'pagseguro_t',1),(25,2,NULL,1198,'pagseguro_t',1),(26,2,NULL,1198,'pagseguro_t',1),(27,2,NULL,1198,'pagseguro_t',1),(28,2,NULL,1198,'pagseguro_t',1),(29,2,NULL,1198,'pagseguro_t',1),(30,2,NULL,1198,'pagseguro_t',1),(31,2,NULL,1198,'pagseguro_t',1);

UNLOCK TABLES;

DROP TABLE IF EXISTS `purchases_products`;


CREATE TABLE `purchases_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_purchase` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

LOCK TABLES `purchases_products` WRITE;

INSERT INTO `purchases_products` VALUES (1,2,3,1,599),(2,3,3,1,599),(3,4,3,1,599),(4,5,3,1,599),(5,6,3,1,599),(6,7,3,1,599),(7,8,3,1,599),(8,9,3,1,599),(9,10,3,1,599),(10,11,3,1,599),(11,12,3,1,599),(12,13,3,1,599),(13,14,3,1,599),(14,15,3,1,599),(15,16,3,1,599),(16,17,3,1,599),(17,18,3,1,599),(18,19,3,1,599),(19,20,3,1,599),(20,21,3,1,599),(21,22,3,2,599),(22,23,3,2,599),(23,24,3,2,599),(24,25,3,2,599),(25,26,3,2,599),(26,27,3,2,599),(27,28,3,2,599),(28,29,3,2,599),(29,30,3,2,599),(30,31,3,2,599);

UNLOCK TABLES;

DROP TABLE IF EXISTS `rates`;

CREATE TABLE `rates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_rated` datetime NOT NULL,
  `points` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `rates` WRITE;

INSERT INTO `rates` VALUES (1,2,1,'2017-01-01 00:00:00',2,'Produto muito legal.'),(2,2,1,'2017-01-02 00:00:00',2,'Produto meio ruim.');

UNLOCK TABLES;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;

INSERT INTO `users` VALUES (1,'ricardo80@gmail.com','202cb962ac59075b964b07152d234b70','Ricardo Senha 123'),(2,'c79968513705754159978@sandbox.pagseguro.com.br','ade07fa21ae892eba3aafb16d2cf39c9',NULL);

UNLOCK TABLES;
