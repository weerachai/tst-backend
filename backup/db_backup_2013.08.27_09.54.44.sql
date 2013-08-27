-- -------------------------------------------
SET AUTOCOMMIT=0;
START TRANSACTION;
SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------
-- -------------------------------------------
-- START BACKUP
-- -------------------------------------------
-- -------------------------------------------
-- TABLE `AuthAssignment`
-- -------------------------------------------
DROP TABLE IF EXISTS `AuthAssignment`;
CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `AuthItem`
-- -------------------------------------------
DROP TABLE IF EXISTS `AuthItem`;
CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `AuthItemChild`
-- -------------------------------------------
DROP TABLE IF EXISTS `AuthItemChild`;
CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(255) NOT NULL,
  `child` varchar(255) NOT NULL,
  PRIMARY KEY (`parent`,`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `BankAccount`
-- -------------------------------------------
DROP TABLE IF EXISTS `BankAccount`;
CREATE TABLE IF NOT EXISTS `BankAccount` (
  `BankId` int(11) NOT NULL AUTO_INCREMENT,
  `Bank` varchar(255) NOT NULL,
  `Branch` varchar(255) NOT NULL,
  `AccountNo` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`BankId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `BillCollection`
-- -------------------------------------------
DROP TABLE IF EXISTS `BillCollection`;
CREATE TABLE IF NOT EXISTS `BillCollection` (
  `CollectionNo` varchar(255) NOT NULL DEFAULT '',
  `SaleId` varchar(255) DEFAULT NULL,
  `CustomerId` varchar(255) DEFAULT NULL,
  `CollectionDate` date DEFAULT NULL,
  `CollectionAmount` decimal(20,2) DEFAULT '0.00',
  `PaidAmount` decimal(20,2) DEFAULT '0.00',
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`CollectionNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Config`
-- -------------------------------------------
DROP TABLE IF EXISTS `Config`;
CREATE TABLE IF NOT EXISTS `Config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DayToClear` int(11) NOT NULL,
  `SaleDiffPercent` int(11) DEFAULT '0',
  `StockDiffPercent` int(11) DEFAULT '0',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ControlNo`
-- -------------------------------------------
DROP TABLE IF EXISTS `ControlNo`;
CREATE TABLE IF NOT EXISTS `ControlNo` (
  `SaleId` varchar(255) NOT NULL,
  `ControlId` varchar(255) NOT NULL,
  `Year` int(11) NOT NULL,
  `Month` int(11) NOT NULL,
  `No` int(11) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`SaleId`,`ControlId`),
  CONSTRAINT `fk_ControlNo_SaleUnit` FOREIGN KEY (`SaleId`) REFERENCES `SaleUnit` (`SaleId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ControlRunning`
-- -------------------------------------------
DROP TABLE IF EXISTS `ControlRunning`;
CREATE TABLE IF NOT EXISTS `ControlRunning` (
  `ControlId` varchar(255) NOT NULL DEFAULT '',
  `ControlName` varchar(255) NOT NULL,
  `Prefix` varchar(255) NOT NULL,
  PRIMARY KEY (`ControlId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Customer`
-- -------------------------------------------
DROP TABLE IF EXISTS `Customer`;
CREATE TABLE IF NOT EXISTS `Customer` (
  `CustomerId` varchar(255) NOT NULL DEFAULT '',
  `SaleId` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `CustomerName` varchar(255) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Trip1` varchar(255) DEFAULT NULL,
  `Trip2` varchar(255) DEFAULT NULL,
  `Trip3` varchar(255) DEFAULT NULL,
  `Province` varchar(255) DEFAULT NULL,
  `District` varchar(255) DEFAULT NULL,
  `SubDistrict` varchar(255) DEFAULT NULL,
  `ZipCode` varchar(255) DEFAULT NULL,
  `AddrNo` varchar(255) DEFAULT NULL,
  `Moo` varchar(255) DEFAULT NULL,
  `Village` varchar(255) DEFAULT NULL,
  `Soi` varchar(255) DEFAULT NULL,
  `Road` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `ContactPerson` varchar(255) DEFAULT NULL,
  `CreditTerm` int(11) DEFAULT '0',
  `CreditLimit` decimal(20,2) DEFAULT '0.00',
  `OverCreditType` varchar(255) DEFAULT NULL,
  `Due` decimal(20,2) DEFAULT '0.00',
  `PoseCheck` decimal(20,2) DEFAULT '0.00',
  `ReturnCheck` decimal(20,2) DEFAULT '0.00',
  `NewFlag` char(1) DEFAULT NULL,
  `DeleteFlag` char(1) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`CustomerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `CustomerTitle`
-- -------------------------------------------
DROP TABLE IF EXISTS `CustomerTitle`;
CREATE TABLE IF NOT EXISTS `CustomerTitle` (
  `CustomerTitle` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`CustomerTitle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `DeliverDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `DeliverDetail`;
CREATE TABLE IF NOT EXISTS `DeliverDetail` (
  `DeliverNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT '0.00',
  `PriceLevel2` decimal(10,2) DEFAULT '0.00',
  `PriceLevel3` decimal(10,2) DEFAULT '0.00',
  `PriceLevel4` decimal(10,2) DEFAULT '0.00',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`DeliverNo`,`ProductId`),
  CONSTRAINT `fk_DeliverDetail_StockRequest` FOREIGN KEY (`DeliverNo`) REFERENCES `StockDeliver` (`DeliverNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Device`
-- -------------------------------------------
DROP TABLE IF EXISTS `Device`;
CREATE TABLE IF NOT EXISTS `Device` (
  `DeviceId` varchar(255) NOT NULL,
  `DeviceKey` varchar(255) DEFAULT NULL,
  `SaleId` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`SaleId`),
  CONSTRAINT `fk_Device_SaleUnit` FOREIGN KEY (`SaleId`) REFERENCES `SaleUnit` (`SaleId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `DeviceSetting`
-- -------------------------------------------
DROP TABLE IF EXISTS `DeviceSetting`;
CREATE TABLE IF NOT EXISTS `DeviceSetting` (
  `SaleId` varchar(255) NOT NULL,
  `SaleType` varchar(255) NOT NULL,
  `PromotionSku` varchar(255) DEFAULT NULL,
  `PromotionGroup` varchar(255) DEFAULT NULL,
  `PromotionBill` varchar(255) DEFAULT NULL,
  `PromotionAccu` varchar(255) DEFAULT NULL,
  `Vat` varchar(255) NOT NULL,
  `OverStock` char(1) NOT NULL,
  `DayToClear` int(11) NOT NULL,
  `ExchangeDiff` int(11) NOT NULL,
  `ExchangePaymentMethod` varchar(255) DEFAULT NULL,
  `Capacity` int(11) DEFAULT '0',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`SaleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `DiscDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `DiscDetail`;
CREATE TABLE IF NOT EXISTS `DiscDetail` (
  `OrderNo` varchar(255) NOT NULL DEFAULT '',
  `PromotionId` varchar(255) NOT NULL DEFAULT '',
  `DiscBaht` decimal(20,2) DEFAULT '0.00',
  `DiscPer1` int(11) DEFAULT '0',
  `DiscPer2` int(11) DEFAULT '0',
  `DiscPer3` int(11) DEFAULT '0',
  `DiscTotal` decimal(20,2) DEFAULT '0.00',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`OrderNo`,`PromotionId`),
  CONSTRAINT `fk_DiscDetail_ProductOrder` FOREIGN KEY (`OrderNo`) REFERENCES `ProductOrder` (`OrderNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Employee`
-- -------------------------------------------
DROP TABLE IF EXISTS `Employee`;
CREATE TABLE IF NOT EXISTS `Employee` (
  `EmployeeId` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  PRIMARY KEY (`EmployeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ExchangeInDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `ExchangeInDetail`;
CREATE TABLE IF NOT EXISTS `ExchangeInDetail` (
  `ExchangeNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT NULL,
  `PriceLevel2` decimal(10,2) DEFAULT NULL,
  `PriceLevel3` decimal(10,2) DEFAULT NULL,
  `PriceLevel4` decimal(10,2) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ExchangeNo`,`ProductId`),
  CONSTRAINT `fk_ExchangeInDetail_ProductOrder` FOREIGN KEY (`ExchangeNo`) REFERENCES `ProductExchange` (`ExchangeNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ExchangeOutDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `ExchangeOutDetail`;
CREATE TABLE IF NOT EXISTS `ExchangeOutDetail` (
  `ExchangeNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT NULL,
  `PriceLevel2` decimal(10,2) DEFAULT NULL,
  `PriceLevel3` decimal(10,2) DEFAULT NULL,
  `PriceLevel4` decimal(10,2) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ExchangeNo`,`ProductId`),
  CONSTRAINT `fk_ExchangeOutDetail_ProductOrder` FOREIGN KEY (`ExchangeNo`) REFERENCES `ProductExchange` (`ExchangeNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `FreeDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `FreeDetail`;
CREATE TABLE IF NOT EXISTS `FreeDetail` (
  `OrderNo` varchar(255) NOT NULL DEFAULT '',
  `PromotionId` varchar(255) NOT NULL DEFAULT '',
  `FreeProductId` varchar(255) NOT NULL DEFAULT '',
  `FreePack` varchar(255) DEFAULT NULL,
  `FreePrice` decimal(10,2) DEFAULT NULL,
  `FreeQty` int(11) DEFAULT '0',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`OrderNo`,`PromotionId`,`FreeProductId`),
  CONSTRAINT `fk_FreeDetail_ProductOrder` FOREIGN KEY (`OrderNo`) REFERENCES `ProductOrder` (`OrderNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `FreeGrp`
-- -------------------------------------------
DROP TABLE IF EXISTS `FreeGrp`;
CREATE TABLE IF NOT EXISTS `FreeGrp` (
  `FreeGrpId` varchar(255) NOT NULL,
  `ProductId` varchar(255) NOT NULL,
  `FreePack` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`FreeGrpId`,`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `GrpLevel1`
-- -------------------------------------------
DROP TABLE IF EXISTS `GrpLevel1`;
CREATE TABLE IF NOT EXISTS `GrpLevel1` (
  `GrpLevel1Id` varchar(255) NOT NULL DEFAULT '',
  `GrpLevel1Name` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`GrpLevel1Id`),
  UNIQUE KEY `GrpLevel1Name` (`GrpLevel1Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `GrpLevel2`
-- -------------------------------------------
DROP TABLE IF EXISTS `GrpLevel2`;
CREATE TABLE IF NOT EXISTS `GrpLevel2` (
  `GrpLevel1Id` varchar(255) NOT NULL,
  `GrpLevel2Id` varchar(255) NOT NULL DEFAULT '',
  `GrpLevel2Name` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`GrpLevel2Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `GrpLevel3`
-- -------------------------------------------
DROP TABLE IF EXISTS `GrpLevel3`;
CREATE TABLE IF NOT EXISTS `GrpLevel3` (
  `GrpLevel2Id` varchar(255) NOT NULL,
  `GrpLevel3Id` varchar(255) NOT NULL DEFAULT '',
  `GrpLevel3Name` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`GrpLevel3Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `IRDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `IRDetail`;
CREATE TABLE IF NOT EXISTS `IRDetail` (
  `IRNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT '0.00',
  `PriceLevel2` decimal(10,2) DEFAULT '0.00',
  `PriceLevel3` decimal(10,2) DEFAULT '0.00',
  `PriceLevel4` decimal(10,2) DEFAULT '0.00',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`IRNo`,`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `InvoiceDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `InvoiceDetail`;
CREATE TABLE IF NOT EXISTS `InvoiceDetail` (
  `InvoiceNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`InvoiceNo`,`ProductId`),
  CONSTRAINT `fk_InvoiceDetail_ProductInvoice` FOREIGN KEY (`InvoiceNo`) REFERENCES `ProductInvoice` (`InvoiceNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `InvoicePayment`
-- -------------------------------------------
DROP TABLE IF EXISTS `InvoicePayment`;
CREATE TABLE IF NOT EXISTS `InvoicePayment` (
  `PaymentId` varchar(255) NOT NULL DEFAULT '',
  `InvoiceNo` varchar(255) NOT NULL DEFAULT '',
  `Amount` decimal(20,2) DEFAULT '0.00',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`PaymentId`,`InvoiceNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `MoneyTransfer`
-- -------------------------------------------
DROP TABLE IF EXISTS `MoneyTransfer`;
CREATE TABLE IF NOT EXISTS `MoneyTransfer` (
  `SaleId` varchar(255) NOT NULL DEFAULT '',
  `TransferDate` date DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date NOT NULL DEFAULT '0000-00-00',
  `Amount` decimal(20,2) DEFAULT '0.00',
  `BankAccount` varchar(255) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`SaleId`,`EndDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `OrderDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `OrderDetail`;
CREATE TABLE IF NOT EXISTS `OrderDetail` (
  `OrderNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `BuyLevel1` int(11) DEFAULT '0',
  `BuyLevel2` int(11) DEFAULT '0',
  `BuyLevel3` int(11) DEFAULT '0',
  `BuyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT NULL,
  `PriceLevel2` decimal(10,2) DEFAULT NULL,
  `PriceLevel3` decimal(10,2) DEFAULT NULL,
  `PriceLevel4` decimal(10,2) DEFAULT NULL,
  `PromotionAccuId` varchar(255) DEFAULT NULL,
  `PromotionAccuType` varchar(255) DEFAULT NULL,
  `OrderNoUsed` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`OrderNo`,`ProductId`),
  CONSTRAINT `fk_OrderDetail_ProductOrder` FOREIGN KEY (`OrderNo`) REFERENCES `ProductOrder` (`OrderNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Payment`
-- -------------------------------------------
DROP TABLE IF EXISTS `Payment`;
CREATE TABLE IF NOT EXISTS `Payment` (
  `CollectionNo` varchar(255) DEFAULT NULL,
  `PaymentId` varchar(255) NOT NULL DEFAULT '',
  `PaymentType` varchar(255) DEFAULT NULL,
  `PaidAmount` decimal(20,2) DEFAULT '0.00',
  `DocNo` varchar(255) DEFAULT NULL,
  `DocDate` varchar(255) DEFAULT NULL,
  `Bank` varchar(255) DEFAULT NULL,
  `Branch` varchar(255) DEFAULT NULL,
  `AccountNo` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`PaymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `PaymentType`
-- -------------------------------------------
DROP TABLE IF EXISTS `PaymentType`;
CREATE TABLE IF NOT EXISTS `PaymentType` (
  `PaymentType` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`PaymentType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Product`
-- -------------------------------------------
DROP TABLE IF EXISTS `Product`;
CREATE TABLE IF NOT EXISTS `Product` (
  `GrpLevel1Id` varchar(255) NOT NULL,
  `GrpLevel2Id` varchar(255) NOT NULL,
  `GrpLevel3Id` varchar(255) NOT NULL,
  `ProductId` varchar(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `PackLevel1` varchar(255) DEFAULT NULL,
  `PackLevel2` varchar(255) DEFAULT NULL,
  `PackLevel3` varchar(255) DEFAULT NULL,
  `PackLevel4` varchar(255) DEFAULT NULL,
  `PriceLevel1` decimal(10,2) DEFAULT NULL,
  `PriceLevel2` decimal(10,2) DEFAULT NULL,
  `PriceLevel3` decimal(10,2) DEFAULT NULL,
  `PriceLevel4` decimal(10,2) DEFAULT NULL,
  `VolumeLevel1` int(11) DEFAULT '0',
  `VolumeLevel2` int(11) DEFAULT '0',
  `VolumeLevel3` int(11) DEFAULT '0',
  `VolumeLevel4` int(11) DEFAULT '0',
  `FreeFlag` char(1) DEFAULT NULL,
  `VatFlag` char(1) DEFAULT NULL,
  `ShipFlag` char(1) DEFAULT NULL,
  `MinShip` decimal(10,2) DEFAULT NULL,
  `ShipFee` decimal(10,2) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ProductExchange`
-- -------------------------------------------
DROP TABLE IF EXISTS `ProductExchange`;
CREATE TABLE IF NOT EXISTS `ProductExchange` (
  `ExchangeNo` varchar(255) NOT NULL DEFAULT '',
  `SaleId` varchar(255) DEFAULT NULL,
  `CustomerId` varchar(255) DEFAULT NULL,
  `ExchangeDate` date DEFAULT NULL,
  `InTotal` decimal(20,2) DEFAULT '0.00',
  `OutTotal` decimal(20,2) DEFAULT '0.00',
  `Paid` decimal(20,2) DEFAULT '0.00',
  `CashFlag` char(1) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ExchangeNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ProductGrp`
-- -------------------------------------------
DROP TABLE IF EXISTS `ProductGrp`;
CREATE TABLE IF NOT EXISTS `ProductGrp` (
  `ProductGrpId` varchar(255) NOT NULL,
  `ProductId` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ProductGrpId`,`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ProductInvoice`
-- -------------------------------------------
DROP TABLE IF EXISTS `ProductInvoice`;
CREATE TABLE IF NOT EXISTS `ProductInvoice` (
  `InvoiceNo` varchar(255) NOT NULL DEFAULT '',
  `OrderNo` varchar(255) DEFAULT NULL,
  `SaleId` varchar(255) DEFAULT NULL,
  `InvoiceDate` date DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `Total` decimal(20,2) DEFAULT '0.00',
  `Paid` decimal(20,2) DEFAULT '0.00',
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`InvoiceNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ProductOrder`
-- -------------------------------------------
DROP TABLE IF EXISTS `ProductOrder`;
CREATE TABLE IF NOT EXISTS `ProductOrder` (
  `OrderNo` varchar(255) NOT NULL DEFAULT '',
  `OrderType` varchar(255) DEFAULT NULL,
  `SaleId` varchar(255) DEFAULT NULL,
  `CustomerId` varchar(255) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `Total` decimal(20,2) DEFAULT '0.00',
  `Vat` decimal(20,2) DEFAULT '0.00',
  `Discount` decimal(20,2) DEFAULT '0.00',
  `Shipping` decimal(20,2) DEFAULT '0.00',
  `DeliverDate` date DEFAULT NULL,
  `DeliverAddress` text,
  `PaymentType` varchar(255) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `Remark` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`OrderNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ProductReturn`
-- -------------------------------------------
DROP TABLE IF EXISTS `ProductReturn`;
CREATE TABLE IF NOT EXISTS `ProductReturn` (
  `ReturnNo` varchar(255) NOT NULL DEFAULT '',
  `SaleId` varchar(255) DEFAULT NULL,
  `CustomerId` varchar(255) DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `Total` decimal(20,2) DEFAULT '0.00',
  `Vat` decimal(20,2) DEFAULT '0.00',
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ReturnNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Promotion`
-- -------------------------------------------
DROP TABLE IF EXISTS `Promotion`;
CREATE TABLE IF NOT EXISTS `Promotion` (
  `PromotionGroup` varchar(255) NOT NULL,
  `PromotionId` varchar(255) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `PromotionType` varchar(255) NOT NULL,
  `ProductOrGrpId` varchar(255) DEFAULT NULL,
  `MinAmount` int(11) DEFAULT '0',
  `MinSku` int(11) DEFAULT '0',
  `MinQty` int(11) DEFAULT '0',
  `Pack` varchar(255) DEFAULT NULL,
  `DiscBaht` int(11) DEFAULT '0',
  `DiscPerAmount` int(11) DEFAULT '0',
  `DiscPerQty` int(11) DEFAULT '0',
  `DiscPer1` int(11) DEFAULT '0',
  `DiscPer2` int(11) DEFAULT '0',
  `DiscPer3` int(11) DEFAULT '0',
  `FreeType` varchar(255) DEFAULT NULL,
  `FreeProductOrGrpId` varchar(255) DEFAULT NULL,
  `FreeQty` int(11) DEFAULT '0',
  `FreePack` varchar(255) DEFAULT NULL,
  `FreePerAmount` int(11) DEFAULT '0',
  `FreePerQty` int(11) DEFAULT '0',
  `FreeBaht` int(11) DEFAULT '0',
  `Formula` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`PromotionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ReceiveDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `ReceiveDetail`;
CREATE TABLE IF NOT EXISTS `ReceiveDetail` (
  `ReceiveNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT '0.00',
  `PriceLevel2` decimal(10,2) DEFAULT '0.00',
  `PriceLevel3` decimal(10,2) DEFAULT '0.00',
  `PriceLevel4` decimal(10,2) DEFAULT '0.00',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ReceiveNo`,`ProductId`),
  CONSTRAINT `fk_ReceiveDetail_StockRequest` FOREIGN KEY (`ReceiveNo`) REFERENCES `StockReceive` (`ReceiveNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `RequestDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `RequestDetail`;
CREATE TABLE IF NOT EXISTS `RequestDetail` (
  `RequestNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT '0.00',
  `PriceLevel2` decimal(10,2) DEFAULT '0.00',
  `PriceLevel3` decimal(10,2) DEFAULT '0.00',
  `PriceLevel4` decimal(10,2) DEFAULT '0.00',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`RequestNo`,`ProductId`),
  CONSTRAINT `fk_RequestDetail_StockRequest` FOREIGN KEY (`RequestNo`) REFERENCES `StockRequest` (`RequestNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `RequestIR`
-- -------------------------------------------
DROP TABLE IF EXISTS `RequestIR`;
CREATE TABLE IF NOT EXISTS `RequestIR` (
  `IRNo` varchar(255) NOT NULL DEFAULT '',
  `RequestNo` varchar(255) NOT NULL DEFAULT '',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`IRNo`,`RequestNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `ReturnDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `ReturnDetail`;
CREATE TABLE IF NOT EXISTS `ReturnDetail` (
  `ReturnNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `MfgDate` date DEFAULT NULL,
  `ExpDate` date DEFAULT NULL,
  `LotNo` varchar(255) DEFAULT NULL,
  `OrderNo` varchar(255) DEFAULT NULL,
  `Reason` varchar(255) DEFAULT NULL,
  `Condition` varchar(255) DEFAULT NULL,
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT NULL,
  `PriceLevel2` decimal(10,2) DEFAULT NULL,
  `PriceLevel3` decimal(10,2) DEFAULT NULL,
  `PriceLevel4` decimal(10,2) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ReturnNo`,`ProductId`),
  CONSTRAINT `fk_ReturnDetail_ProductReturn` FOREIGN KEY (`ReturnNo`) REFERENCES `ProductReturn` (`ReturnNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `SaleArea`
-- -------------------------------------------
DROP TABLE IF EXISTS `SaleArea`;
CREATE TABLE IF NOT EXISTS `SaleArea` (
  `AreaId` varchar(255) NOT NULL,
  `AreaName` varchar(255) NOT NULL,
  `SupervisorId` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`AreaId`),
  KEY `fk_SaleArea_Employee` (`SupervisorId`),
  CONSTRAINT `fk_SaleArea_Employee` FOREIGN KEY (`SupervisorId`) REFERENCES `Employee` (`EmployeeId`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `SaleHistory`
-- -------------------------------------------
DROP TABLE IF EXISTS `SaleHistory`;
CREATE TABLE IF NOT EXISTS `SaleHistory` (
  `SaleId` varchar(255) NOT NULL DEFAULT '',
  `CustomerId` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `SaleAvg` varchar(255) DEFAULT NULL,
  `M01` varchar(255) DEFAULT NULL,
  `M02` varchar(255) DEFAULT NULL,
  `M03` varchar(255) DEFAULT NULL,
  `M04` varchar(255) DEFAULT NULL,
  `M05` varchar(255) DEFAULT NULL,
  `M06` varchar(255) DEFAULT NULL,
  `M07` varchar(255) DEFAULT NULL,
  `M08` varchar(255) DEFAULT NULL,
  `M09` varchar(255) DEFAULT NULL,
  `M10` varchar(255) DEFAULT NULL,
  `M11` varchar(255) DEFAULT NULL,
  `M12` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`SaleId`,`CustomerId`,`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `SaleUnit`
-- -------------------------------------------
DROP TABLE IF EXISTS `SaleUnit`;
CREATE TABLE IF NOT EXISTS `SaleUnit` (
  `SaleId` varchar(255) NOT NULL,
  `SaleName` varchar(255) NOT NULL,
  `SaleType` varchar(255) NOT NULL,
  `EmployeeId` varchar(255) DEFAULT NULL,
  `AreaId` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`SaleId`),
  KEY `fk_SaleUnit_Employee` (`EmployeeId`),
  KEY `fk_SaleUnit_SaleArea` (`AreaId`),
  CONSTRAINT `fk_SaleUnit_SaleArea` FOREIGN KEY (`AreaId`) REFERENCES `SaleArea` (`AreaId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_SaleUnit_Employee` FOREIGN KEY (`EmployeeId`) REFERENCES `Employee` (`EmployeeId`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Stock`
-- -------------------------------------------
DROP TABLE IF EXISTS `Stock`;
CREATE TABLE IF NOT EXISTS `Stock` (
  `SaleId` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `StartQtyLevel1` int(11) DEFAULT '0',
  `StartQtyLevel2` int(11) DEFAULT '0',
  `StartQtyLevel3` int(11) DEFAULT '0',
  `StartQtyLevel4` int(11) DEFAULT '0',
  `CurrentQtyLevel1` int(11) DEFAULT '0',
  `CurrentQtyLevel2` int(11) DEFAULT '0',
  `CurrentQtyLevel3` int(11) DEFAULT '0',
  `CurrentQtyLevel4` int(11) DEFAULT '0',
  `BadQtyLevel1` int(11) DEFAULT '0',
  `BadQtyLevel2` int(11) DEFAULT '0',
  `BadQtyLevel3` int(11) DEFAULT '0',
  `BadQtyLevel4` int(11) DEFAULT '0',
  `MidInQtyLevel1` int(11) DEFAULT '0',
  `MidInQtyLevel2` int(11) DEFAULT '0',
  `MidInQtyLevel3` int(11) DEFAULT '0',
  `MidInQtyLevel4` int(11) DEFAULT '0',
  `ReturnQtyLevel1` int(11) DEFAULT '0',
  `ReturnQtyLevel2` int(11) DEFAULT '0',
  `ReturnQtyLevel3` int(11) DEFAULT '0',
  `ReturnQtyLevel4` int(11) DEFAULT '0',
  `ReplaceQtyLevel1` int(11) DEFAULT '0',
  `ReplaceQtyLevel2` int(11) DEFAULT '0',
  `ReplaceQtyLevel3` int(11) DEFAULT '0',
  `ReplaceQtyLevel4` int(11) DEFAULT '0',
  `SaleQtyLevel1` int(11) DEFAULT '0',
  `SaleQtyLevel2` int(11) DEFAULT '0',
  `SaleQtyLevel3` int(11) DEFAULT '0',
  `SaleQtyLevel4` int(11) DEFAULT '0',
  `FreeQtyLevel1` int(11) DEFAULT '0',
  `FreeQtyLevel2` int(11) DEFAULT '0',
  `FreeQtyLevel3` int(11) DEFAULT '0',
  `FreeQtyLevel4` int(11) DEFAULT '0',
  `MidOutQtyLevel1` int(11) DEFAULT '0',
  `MidOutQtyLevel2` int(11) DEFAULT '0',
  `MidOutQtyLevel3` int(11) DEFAULT '0',
  `MidOutQtyLevel4` int(11) DEFAULT '0',
  `EndQtyLevel1` int(11) DEFAULT '0',
  `EndQtyLevel2` int(11) DEFAULT '0',
  `EndQtyLevel3` int(11) DEFAULT '0',
  `EndQtyLevel4` int(11) DEFAULT '0',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`SaleId`,`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `StockCheck`
-- -------------------------------------------
DROP TABLE IF EXISTS `StockCheck`;
CREATE TABLE IF NOT EXISTS `StockCheck` (
  `SaleId` varchar(255) DEFAULT NULL,
  `Month` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `CustomerId` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `FrontQtyLevel1` int(11) DEFAULT '0',
  `FrontQtyLevel2` int(11) DEFAULT '0',
  `FrontQtyLevel3` int(11) DEFAULT '0',
  `FrontQtyLevel4` int(11) DEFAULT '0',
  `BackQtyLevel1` int(11) DEFAULT '0',
  `BackQtyLevel2` int(11) DEFAULT '0',
  `BackQtyLevel3` int(11) DEFAULT '0',
  `BackQtyLevel4` int(11) DEFAULT '0',
  `BuyQtyLevel1` int(11) DEFAULT '0',
  `BuyQtyLevel2` int(11) DEFAULT '0',
  `BuyQtyLevel3` int(11) DEFAULT '0',
  `BuyQtyLevel4` int(11) DEFAULT '0',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`Month`,`Year`,`CustomerId`,`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `StockCheckList`
-- -------------------------------------------
DROP TABLE IF EXISTS `StockCheckList`;
CREATE TABLE IF NOT EXISTS `StockCheckList` (
  `SaleId` varchar(255) NOT NULL,
  `GrpLevel1Id` varchar(255) NOT NULL,
  `GrpLevel2Id` varchar(255) NOT NULL,
  `GrpLevel3Id` varchar(255) NOT NULL,
  `ProductId` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `StockDeliver`
-- -------------------------------------------
DROP TABLE IF EXISTS `StockDeliver`;
CREATE TABLE IF NOT EXISTS `StockDeliver` (
  `RequestNo` varchar(255) DEFAULT NULL,
  `DeliverNo` varchar(255) NOT NULL DEFAULT '',
  `SaleId` varchar(255) DEFAULT NULL,
  `WarehouseId` varchar(255) DEFAULT NULL,
  `WarehouseName` varchar(255) DEFAULT NULL,
  `WarehouseType` varchar(255) DEFAULT NULL,
  `DeliverDate` date DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT '0.00',
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`DeliverNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `StockIR`
-- -------------------------------------------
DROP TABLE IF EXISTS `StockIR`;
CREATE TABLE IF NOT EXISTS `StockIR` (
  `IRNo` varchar(255) NOT NULL DEFAULT '',
  `SaleId` varchar(255) DEFAULT NULL,
  `IRDate` date DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT '0.00',
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`IRNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `StockReceive`
-- -------------------------------------------
DROP TABLE IF EXISTS `StockReceive`;
CREATE TABLE IF NOT EXISTS `StockReceive` (
  `RequestNo` varchar(255) DEFAULT NULL,
  `DeliverNo` varchar(255) DEFAULT NULL,
  `ReceiveNo` varchar(255) NOT NULL DEFAULT '',
  `SaleId` varchar(255) DEFAULT NULL,
  `ReceiveDate` date DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT '0.00',
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ReceiveNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `StockRequest`
-- -------------------------------------------
DROP TABLE IF EXISTS `StockRequest`;
CREATE TABLE IF NOT EXISTS `StockRequest` (
  `RequestNo` varchar(255) NOT NULL DEFAULT '',
  `RequestType` varchar(255) DEFAULT 'สร้างโดย Backend',
  `RequestFlag` varchar(255) DEFAULT 'ต้นทริป',
  `SaleId` varchar(255) DEFAULT NULL,
  `WarehouseId` varchar(255) DEFAULT NULL,
  `WarehouseName` varchar(255) DEFAULT NULL,
  `WarehouseType` varchar(255) DEFAULT NULL,
  `RequestDate` date DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT '0.00',
  `Status` varchar(255) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`RequestNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `StockStartList`
-- -------------------------------------------
DROP TABLE IF EXISTS `StockStartList`;
CREATE TABLE IF NOT EXISTS `StockStartList` (
  `SaleId` varchar(255) DEFAULT NULL,
  `ProductId` varchar(255) DEFAULT NULL,
  `Level` int(11) DEFAULT '1',
  `Qty` int(11) DEFAULT '0',
  `UpdateAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `StockTransfer`
-- -------------------------------------------
DROP TABLE IF EXISTS `StockTransfer`;
CREATE TABLE IF NOT EXISTS `StockTransfer` (
  `TransferNo` varchar(255) NOT NULL DEFAULT '',
  `SaleId` varchar(255) DEFAULT NULL,
  `WarehouseId` varchar(255) DEFAULT NULL,
  `WarehouseName` varchar(255) DEFAULT NULL,
  `WarehouseType` varchar(255) DEFAULT NULL,
  `TransferDate` date DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT '0.00',
  `Status` varchar(255) DEFAULT NULL,
  `EndTripFlag` char(1) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`TransferNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `TargetSale`
-- -------------------------------------------
DROP TABLE IF EXISTS `TargetSale`;
CREATE TABLE IF NOT EXISTS `TargetSale` (
  `SaleId` varchar(255) NOT NULL,
  `Level` varchar(255) NOT NULL,
  `ProductOrGrpId` varchar(255) DEFAULT NULL,
  `TargetAmount` int(11) DEFAULT '0',
  `TargetQty` int(11) DEFAULT '0',
  `TargetPack` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `TransferDetail`
-- -------------------------------------------
DROP TABLE IF EXISTS `TransferDetail`;
CREATE TABLE IF NOT EXISTS `TransferDetail` (
  `TransferNo` varchar(255) NOT NULL DEFAULT '',
  `ProductId` varchar(255) NOT NULL DEFAULT '',
  `QtyLevel1` int(11) DEFAULT '0',
  `QtyLevel2` int(11) DEFAULT '0',
  `QtyLevel3` int(11) DEFAULT '0',
  `QtyLevel4` int(11) DEFAULT '0',
  `PriceLevel1` decimal(10,2) DEFAULT '0.00',
  `PriceLevel2` decimal(10,2) DEFAULT '0.00',
  `PriceLevel3` decimal(10,2) DEFAULT '0.00',
  `PriceLevel4` decimal(10,2) DEFAULT '0.00',
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`TransferNo`,`ProductId`),
  CONSTRAINT `fk_TransferDetail_StockRequest` FOREIGN KEY (`TransferNo`) REFERENCES `StockTransfer` (`TransferNo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Trip`
-- -------------------------------------------
DROP TABLE IF EXISTS `Trip`;
CREATE TABLE IF NOT EXISTS `Trip` (
  `TripId` int(11) NOT NULL AUTO_INCREMENT,
  `TripName` varchar(255) NOT NULL,
  PRIMARY KEY (`TripId`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `User`
-- -------------------------------------------
DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `employee` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `Warehouse`
-- -------------------------------------------
DROP TABLE IF EXISTS `Warehouse`;
CREATE TABLE IF NOT EXISTS `Warehouse` (
  `WarehouseId` varchar(255) NOT NULL,
  `WarehouseName` varchar(255) NOT NULL,
  `WarehouseType` varchar(255) NOT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`WarehouseId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE `tbl_migration`
-- -------------------------------------------
DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE DATA AuthAssignment
-- -------------------------------------------
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('admin','1','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('manager','2','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('staff','3','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('supervisor','4','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('employee','5','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('user','6','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('user','7','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('user','8','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('user','9','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('user','10','','N;');



-- -------------------------------------------
-- TABLE DATA AuthItem
-- -------------------------------------------
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('admin','2','System Administrator','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('employee','2','Employee','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('manager','2','System Manager','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('staff','2','Adminstrative Staff','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('supervisor','2','Supervisor','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('updateSelf','1','Update own information','return Yii::app()->user->id==$params;','N;');



-- -------------------------------------------
-- TABLE DATA AuthItemChild
-- -------------------------------------------
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','manager');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('employee','updateSelf');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('manager','staff');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('staff','supervisor');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('supervisor','employee');



-- -------------------------------------------
-- TABLE DATA BankAccount
-- -------------------------------------------
INSERT INTO `BankAccount` (`BankId`,`Bank`,`Branch`,`AccountNo`,`UpdateAt`) VALUES
('1','กรุงเทพ','รังสิต','111-111111-1','2013-08-25 21:13:23');
INSERT INTO `BankAccount` (`BankId`,`Bank`,`Branch`,`AccountNo`,`UpdateAt`) VALUES
('2','ไทยพาณิชย์','รังสิต','222-222222-2','2013-08-25 21:13:23');
INSERT INTO `BankAccount` (`BankId`,`Bank`,`Branch`,`AccountNo`,`UpdateAt`) VALUES
('3','กสิกร','รังสิต','333-333333-3','2013-08-25 21:13:23');
INSERT INTO `BankAccount` (`BankId`,`Bank`,`Branch`,`AccountNo`,`UpdateAt`) VALUES
('4','ทหารไทย','รังสิต','444-444444-4','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA Config
-- -------------------------------------------
INSERT INTO `Config` (`id`,`DayToClear`,`SaleDiffPercent`,`StockDiffPercent`,`UpdateAt`) VALUES
('1','120','0','0','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA ControlNo
-- -------------------------------------------
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C01','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C02','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C03','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C04','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C05','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C06','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C07','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C08','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C09','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C10','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C11','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C12','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C13','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N001','C14','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C01','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C02','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C03','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C04','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C05','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C06','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C07','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C08','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C09','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C10','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C11','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C12','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C13','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N002','C14','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C01','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C02','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C03','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C04','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C05','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C06','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C07','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C08','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C09','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C10','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C11','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C12','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C13','13','8','1','2013-08-25 21:13:23');
INSERT INTO `ControlNo` (`SaleId`,`ControlId`,`Year`,`Month`,`No`,`UpdateAt`) VALUES
('N003','C14','13','8','1','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA ControlRunning
-- -------------------------------------------
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C01','Sale Order','SO');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C02','Invoice','IN');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C03','รับคืนสินค้า','RE');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C04','เปลี่ยนสินค้า','EX');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C05','ใบเบิกสินค้า','RQ');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C06','ใบส่งสินค้า','SN');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C07','ใบรับสินค้า','RC');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C08','รหัสร้านค้า','CU');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C09','Bill Collection','BC');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C10','Payment','PM');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C11','โอนสินค้า','TX');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C12','ใบเบิกสินค้า-backend','RQ');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C13','ใบส่งสินค้า-backend','SN');
INSERT INTO `ControlRunning` (`ControlId`,`ControlName`,`Prefix`) VALUES
('C14','IR-backend','IR');



-- -------------------------------------------
-- TABLE DATA Customer
-- -------------------------------------------
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00113050001','N001','ร้าน','สุขใจ 1','CH','วันจันทร์','วันพุธ','','ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','33','5','สบายดี','4','พหลโยธิน','02-564-3333','คุณอ้อย','30','20000.00','N','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00113050002','N001','ร้าน','มีดี 1','CH','วันจันทร์','วันศุกร์','','ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','11','2','ชมฟ้า','1','รังสิต-นครนายก','02-564-5555','คุณเอ','60','30000.00','P','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00113050003','N001','ร้าน','ใจดี 1','CR','วันอังคาร','วันพุธ','','นนทบุรี','บางกรวย','บางกรวย','11130','33','5','สบายดี','4','ติวานนท์','02-564-6666','คุณส้ม','30','20000.00','N','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00113050004','N001','ร้าน','รวยดี 1','CR','วันอังคาร','วันศุกร์','','นนทบุรี','บางกรวย','บางกรวย','11130','11','2','ชมฟ้า','1','ติวานนท์','02-564-7777','คุณรวย','60','30000.00','P','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00213050001','N002','ร้าน','สุขใจ 2','CH','วันจันทร์','วันพุธ','','ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','33','5','สบายดี','4','พหลโยธิน','02-564-3333','คุณอ้อย','0','0.00','N','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00213050002','N002','ร้าน','มีดี 2','CH','วันจันทร์','วันศุกร์','','ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','11','2','ชมฟ้า','1','รังสิต-นครนายก','02-564-5555','คุณเอ','0','0.00','P','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00213050003','N002','ร้าน','ใจดี 2','CH','วันอังคาร','วันพุธ','','นนทบุรี','บางกรวย','บางกรวย','11130','33','5','สบายดี','4','ติวานนท์','02-564-6666','คุณส้ม','0','0.00','N','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00213050004','N002','ร้าน','รวยดี 2','CH','วันอังคาร','วันศุกร์','','นนทบุรี','บางกรวย','บางกรวย','11130','11','2','ชมฟ้า','1','ติวานนท์','02-564-7777','คุณรวย','0','0.00','P','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00313050001','N003','ร้าน','สุขใจ 3','CH','วันจันทร์','วันพุธ','','ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','33','5','สบายดี','4','พหลโยธิน','02-564-3333','คุณอ้อย','0','0.00','N','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00313050002','N003','ร้าน','มีดี 3','CH','วันจันทร์','วันศุกร์','','ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','11','2','ชมฟ้า','1','รังสิต-นครนายก','02-564-5555','คุณเอ','0','0.00','P','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00313050003','N003','ร้าน','ใจดี 3','CH','วันอังคาร','วันพุธ','','นนทบุรี','บางกรวย','บางกรวย','11130','33','5','สบายดี','4','ติวานนท์','02-564-6666','คุณส้ม','0','0.00','N','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');
INSERT INTO `Customer` (`CustomerId`,`SaleId`,`Title`,`CustomerName`,`Type`,`Trip1`,`Trip2`,`Trip3`,`Province`,`District`,`SubDistrict`,`ZipCode`,`AddrNo`,`Moo`,`Village`,`Soi`,`Road`,`Phone`,`ContactPerson`,`CreditTerm`,`CreditLimit`,`OverCreditType`,`Due`,`PoseCheck`,`ReturnCheck`,`NewFlag`,`DeleteFlag`,`UpdateAt`) VALUES
('CUD00313050004','N003','ร้าน','รวยดี 3','CH','วันอังคาร','วันศุกร์','','นนทบุรี','บางกรวย','บางกรวย','11130','11','2','ชมฟ้า','1','ติวานนท์','02-564-7777','คุณรวย','0','0.00','P','0.00','0.00','0.00','N','N','2013-08-25 21:13:24');



-- -------------------------------------------
-- TABLE DATA CustomerTitle
-- -------------------------------------------
INSERT INTO `CustomerTitle` (`CustomerTitle`,`UpdateAt`) VALUES
('บมจ.','2013-08-25 21:13:23');
INSERT INTO `CustomerTitle` (`CustomerTitle`,`UpdateAt`) VALUES
('ร้าน','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA Device
-- -------------------------------------------
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D001','','N001','D001','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D002','','N002','D002','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D003','','N003','D003','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D004','','N004','D004','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D005','','N005','D005','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D006','','N006','D006','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D007','','N007','D007','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D008','','N008','D008','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D009','','N009','D009','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D010','','N010','D010','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D011','','N011','D011','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D012','','N012','D012','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D013','','N013','D013','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D014','','N014','D014','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D015','','N015','D015','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D016','','N016','D016','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D017','','N017','D017','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D018','','N018','D018','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D019','','N019','D019','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D020','','N020','D020','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D021','','N021','D021','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D022','','N022','D022','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D023','','N023','D023','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D024','','N024','D024','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');
INSERT INTO `Device` (`DeviceId`,`DeviceKey`,`SaleId`,`Username`,`Password`,`UpdateAt`) VALUES
('D025','','N025','D025','1a3b0cc7ede95099129197b513be8bee','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA DeviceSetting
-- -------------------------------------------
INSERT INTO `DeviceSetting` (`SaleId`,`SaleType`,`PromotionSku`,`PromotionGroup`,`PromotionBill`,`PromotionAccu`,`Vat`,`OverStock`,`DayToClear`,`ExchangeDiff`,`ExchangePaymentMethod`,`Capacity`,`UpdateAt`) VALUES
('N001','เครดิต','A','M','B','AC','sku','Y','120','0','','0','2013-08-25 21:20:59');
INSERT INTO `DeviceSetting` (`SaleId`,`SaleType`,`PromotionSku`,`PromotionGroup`,`PromotionBill`,`PromotionAccu`,`Vat`,`OverStock`,`DayToClear`,`ExchangeDiff`,`ExchangePaymentMethod`,`Capacity`,`UpdateAt`) VALUES
('N002','หน่วยรถ','A','M','B','AC','sku','Y','120','50','bill','20000','2013-08-25 21:20:59');
INSERT INTO `DeviceSetting` (`SaleId`,`SaleType`,`PromotionSku`,`PromotionGroup`,`PromotionBill`,`PromotionAccu`,`Vat`,`OverStock`,`DayToClear`,`ExchangeDiff`,`ExchangePaymentMethod`,`Capacity`,`UpdateAt`) VALUES
('N003','หน่วยรถ','A','M','B','AC','sku','N','120','50','cash','20000','2013-08-25 21:20:59');



-- -------------------------------------------
-- TABLE DATA Employee
-- -------------------------------------------
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E001','นายสมมติ ข','นามสกุลสมมติ 1');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E002','นายสมมติ ค','นามสกุลสมมติ 2');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E003','นายสมมติ ม','นามสกุลสมมติ 3');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E004','นายสมมติ ง','นามสกุลสมมติ 4');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E005','นายสมมติ จ','นามสกุลสมมติ 5');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E006','นายสมมติ ฉ','นามสกุลสมมติ 6');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E007','นายสมมติ ช','นามสกุลสมมติ 7');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E008','นายสมมติ ซ','นามสกุลสมมติ 8');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E009','นายสมมติ ฌ','นามสกุลสมมติ 9');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E010','นายสมมติ ญ','นามสกุลสมมติ 10');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E011','นายสมมติ ฎ','นามสกุลสมมติ 11');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E012','นายสมมติ ฏ','นามสกุลสมมติ 12');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E013','นายสมมติ ฐ','นามสกุลสมมติ 13');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E014','นายสมมติ ฑ','นามสกุลสมมติ 14');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E015','นายสมมติ ฒ','นามสกุลสมมติ 15');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E016','นายสมมติ ณ','นามสกุลสมมติ 16');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E017','นายสมมติ ด','นามสกุลสมมติ 17');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E018','นายสมมติ ต','นามสกุลสมมติ 18');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E019','นายสมมติ ถ','นามสกุลสมมติ 19');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E020','นายสมมติ ท','นามสกุลสมมติ 20');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E021','นายสมมติ ธ','นามสกุลสมมติ 21');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E022','นายสมมติ บ','นามสกุลสมมติ 22');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E023','นายสมมติ ป','นามสกุลสมมติ 23');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E024','นายสมมติ ผ','นามสกุลสมมติ 24');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('E025','นายสมมติ ฝ','นามสกุลสมมติ 25');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('S001','นายซุป 1','นามสกุลซุป 1');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('S002','นายซุป 2','นามสกุลซุป 2');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('S003','นายซุป 3','นามสกุลซุป 3');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('S004','นายซุป 4','นามสกุลซุป 4');
INSERT INTO `Employee` (`EmployeeId`,`FirstName`,`LastName`) VALUES
('S005','นายซุป 5','นามสกุลซุป 5');



-- -------------------------------------------
-- TABLE DATA FreeGrp
-- -------------------------------------------
INSERT INTO `FreeGrp` (`FreeGrpId`,`ProductId`,`FreePack`,`UpdateAt`) VALUES
('A','0050100001','กระป๋อง','2013-08-25 21:13:24');
INSERT INTO `FreeGrp` (`FreeGrpId`,`ProductId`,`FreePack`,`UpdateAt`) VALUES
('A','0050100002','กระป๋อง','2013-08-25 21:13:24');
INSERT INTO `FreeGrp` (`FreeGrpId`,`ProductId`,`FreePack`,`UpdateAt`) VALUES
('A','0050100003','กระป๋อง','2013-08-25 21:13:24');
INSERT INTO `FreeGrp` (`FreeGrpId`,`ProductId`,`FreePack`,`UpdateAt`) VALUES
('A','0050100004','กระป๋อง','2013-08-25 21:13:24');
INSERT INTO `FreeGrp` (`FreeGrpId`,`ProductId`,`FreePack`,`UpdateAt`) VALUES
('A','0050100005','กระป๋อง','2013-08-25 21:13:24');



-- -------------------------------------------
-- TABLE DATA GrpLevel1
-- -------------------------------------------
INSERT INTO `GrpLevel1` (`GrpLevel1Id`,`GrpLevel1Name`,`UpdateAt`) VALUES
('306','GUNDAM','2013-08-25 21:13:23');
INSERT INTO `GrpLevel1` (`GrpLevel1Id`,`GrpLevel1Name`,`UpdateAt`) VALUES
('309','COOK','2013-08-25 21:13:23');
INSERT INTO `GrpLevel1` (`GrpLevel1Id`,`GrpLevel1Name`,`UpdateAt`) VALUES
('312','NECTRA','2013-08-25 21:13:23');
INSERT INTO `GrpLevel1` (`GrpLevel1Id`,`GrpLevel1Name`,`UpdateAt`) VALUES
('313','SEALECT','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA GrpLevel2
-- -------------------------------------------
INSERT INTO `GrpLevel2` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel2Name`,`UpdateAt`) VALUES
('309','144','น้ำมันพืชกุ๊กขวด','2013-08-25 21:13:23');
INSERT INTO `GrpLevel2` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel2Name`,`UpdateAt`) VALUES
('309','145','น้ำมันพืชกุ๊กปี๊ป','2013-08-25 21:13:23');
INSERT INTO `GrpLevel2` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel2Name`,`UpdateAt`) VALUES
('313','167','ทูน่า-ซีเล็ก','2013-08-25 21:13:23');
INSERT INTO `GrpLevel2` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel2Name`,`UpdateAt`) VALUES
('313','168','ซีเล็กในซอสมะเขือเทศ','2013-08-25 21:13:23');
INSERT INTO `GrpLevel2` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel2Name`,`UpdateAt`) VALUES
('312','186','ผลิตภัณฑ์ตราเน็กตร้า','2013-08-25 21:13:23');
INSERT INTO `GrpLevel2` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel2Name`,`UpdateAt`) VALUES
('306','190','ข้าวโพดอบกรอบฮิโรชิกันดั้ม','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA PaymentType
-- -------------------------------------------
INSERT INTO `PaymentType` (`PaymentType`,`UpdateAt`) VALUES
('CN','2013-08-25 21:13:23');
INSERT INTO `PaymentType` (`PaymentType`,`UpdateAt`) VALUES
('เงินสด','2013-08-25 21:13:23');
INSERT INTO `PaymentType` (`PaymentType`,`UpdateAt`) VALUES
('เช็ค','2013-08-25 21:13:23');
INSERT INTO `PaymentType` (`PaymentType`,`UpdateAt`) VALUES
('โอนเงินสด','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA Product
-- -------------------------------------------
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('309','144','','0010100001','น้ำมันกุ๊กถั่วเหลือง 1/4 ลิตร','หีบ','ห่อ','','','614.37','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('309','144','','0010200001','น้ำมันกุ๊กถั่วเหลือง 1/2 ลิตร','หีบ','','ห่อ','','555.77','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('309','144','','0010300001','น้ำมันกุ๊กทานตะวัน 1/2 ลิตร','หีบ','','','ห่อ','913.89','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('309','144','','0010400001','น้ำมันกุ๊กถั่วเหลือง 1 ลิตร','หีบ','','','','525.39','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('313','167','','0050100001','ซีเล็กแซนวิชน้ำมัน 185 กรัม','หีบ','','','','1284.00','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('313','167','','0050100002','ซีเล็กแซนวิชน้ำเกลือ 185 กรัม','หีบ','','','','1284.00','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('313','167','','0050100003','ซีเล็กแซนวิชน้ำมัน 185 กรัม แพ็ค 4','หีบ','','','','1284.00','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('313','167','','0050100004','ซีเล็กแซนวิชน้ำเปล่า 185 กรัม','หีบ','','','','1284.00','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');
INSERT INTO `Product` (`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`ProductName`,`PackLevel1`,`PackLevel2`,`PackLevel3`,`PackLevel4`,`PriceLevel1`,`PriceLevel2`,`PriceLevel3`,`PriceLevel4`,`VolumeLevel1`,`VolumeLevel2`,`VolumeLevel3`,`VolumeLevel4`,`FreeFlag`,`VatFlag`,`ShipFlag`,`MinShip`,`ShipFee`,`UpdateAt`) VALUES
('313','167','','0050100005','ซีเล็กแซนวิชน้ำแร่ 185 กรัม','หีบ','','','','1284.00','0.00','0.00','0.00','100','0','0','0','N','Y','N','5000.00','100.00','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA ProductGrp
-- -------------------------------------------
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('A','0050100001','2013-08-25 21:13:24');
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('A','0050100002','2013-08-25 21:13:24');
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('A','0050100003','2013-08-25 21:13:24');
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('A','0050100004','2013-08-25 21:13:24');
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('A','0050100005','2013-08-25 21:13:24');
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('B','0010100001','2013-08-25 21:13:24');
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('B','0010200001','2013-08-25 21:13:24');
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('B','0010300001','2013-08-25 21:13:24');
INSERT INTO `ProductGrp` (`ProductGrpId`,`ProductId`,`UpdateAt`) VALUES
('B','0010400001','2013-08-25 21:13:24');



-- -------------------------------------------
-- TABLE DATA Promotion
-- -------------------------------------------
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A1','2012-08-01','2013-12-30','sku','0050100003','0','0','1','หีบ','5','0','1','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A10','2012-08-01','2013-12-30','sku','0050100002','100','0','0','','5','100','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A11','2012-08-01','2013-12-30','sku','0050100002','1100','0','0','','5','100','0','0','0','0','G','A','1','กระป๋อง','100','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A2','2012-08-01','2013-12-30','sku','0050100003','0','0','11','หีบ','5','0','1','0','0','0','S','0050100003','1','กระป๋อง','0','1','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A3','2012-08-01','2013-12-30','sku','0050100003','0','0','21','หีบ','5','0','1','0','0','0','S','0050100003','1','กระป๋อง','0','1','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A4','2012-08-01','2013-12-30','sku','0050100003','0','0','31','หีบ','5','0','1','0','0','0','S','0050100003','1','กระป๋อง','0','1','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A5','2012-08-01','2013-12-30','sku','0050100003','0','0','41','หีบ','5','0','1','0','0','0','S','0050100003','1','กระป๋อง','0','1','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A6','2012-08-01','2013-12-30','sku','0050100003','0','0','51','หีบ','5','0','1','0','0','0','S','0050100003','1','กระป๋อง','0','1','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A8','2012-08-01','2013-12-30','sku','0050100001','100','0','0','','5','100','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','A9','2012-08-01','2013-12-30','sku','0050100001','1100','0','0','','5','100','0','0','0','0','G','A','1','กระป๋อง','100','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AA','AA','2013-08-21','2013-08-09','sku','0010100001','0','0','1','หีบ','0','0','0','1','1','1','S','0010100001','1','หีบ','0','0','0','F','0000-00-00 00:00:00');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AA','AAA','2013-09-01','2013-10-31','sku','0010100001','10','0','1','หีบ','60','1','1','0','0','0','S','0010100001','1','หีบ','5','1','0','F','0000-00-00 00:00:00');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('A','AAAA','2013-09-01','2013-12-30','sku','0050100001','1000','0','0','','10','100','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-A1','2012-08-01','2013-12-30','accu-all','','1000','0','0','','0','0','0','0','0','0','G','A','0','','0','0','50','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-A2','2012-08-01','2013-12-30','accu-all','','5000','0','0','','0','0','0','5','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-A3','2012-08-01','2013-12-30','accu-all','','10000','0','0','','0','0','0','2','0','0','G','A','0','','0','0','150','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-A4','2012-08-01','2013-12-30','accu-all','','15000','0','0','','500','0','0','0','0','0','G','A','0','','0','0','200','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-A5','2012-08-01','2013-12-30','accu-all','','20000','0','0','','1000','0','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-A6','2012-08-01','2013-12-30','accu-all','','25000','0','0','','1500','0','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-A7','2012-08-01','2013-12-30','accu-all','','25000','0','0','','1500','0','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-B1','2012-08-01','2013-12-30','accu-l1','313','1000','0','0','','0','0','0','0','0','0','G','A','0','','0','0','50','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-B2','2012-08-01','2013-12-30','accu-l1','313','5000','0','0','','0','0','0','5','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-B3','2012-08-01','2013-12-30','accu-l1','313','10000','0','0','','0','0','0','2','0','0','G','A','0','','0','0','150','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-B4','2012-08-01','2013-12-30','accu-l1','313','15000','0','0','','500','0','0','0','0','0','G','A','0','','0','0','200','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-B5','2012-08-01','2013-12-30','accu-l1','313','20000','0','0','','1000','0','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-B6','2012-08-01','2013-12-30','accu-l1','313','25000','0','0','','1500','0','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AC','AC-B7','2012-08-01','2013-12-30','accu-l1','313','25000','0','0','','1500','0','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('B','B1','2012-08-01','2013-12-30','bill','','1000','0','0','','0','0','0','0','0','0','G','A','0','','0','0','50','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('B','B2','2012-08-01','2013-12-30','bill','','5000','0','0','','0','0','0','5','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('B','B3','2012-08-01','2013-12-30','bill','','10000','0','0','','0','0','0','2','0','0','G','A','0','','0','0','150','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('B','B4','2012-08-01','2013-12-30','bill','','15000','0','0','','500','0','0','0','0','0','G','A','0','','0','0','200','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('B','B5','2012-08-01','2013-12-30','bill','','20000','0','0','','1000','0','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('B','B6','2012-08-01','2013-12-30','bill','','25000','0','0','','1500','0','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('AA','BB','2013-08-31','2013-09-28','sku','0010100001','5','0','5','หีบ','0','0','0','0','0','0','S','0010100001','6','หีบ','0','0','0','F','0000-00-00 00:00:00');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('M','M1','2012-08-01','2013-12-30','group','A','100','0','0','','3','100','0','0','0','0','S','0050100003','1','กระป๋อง','100','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('M','M2','2012-08-01','2013-12-30','group','A','1100','0','0','','5','100','0','0','0','0','S','0050100003','1','กระป๋อง','100','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('M','M3','2012-08-01','2013-12-30','group','B','100','0','0','','5','100','0','0','0','0','','','0','','0','0','0','F','2013-08-25 21:13:24');
INSERT INTO `Promotion` (`PromotionGroup`,`PromotionId`,`StartDate`,`EndDate`,`PromotionType`,`ProductOrGrpId`,`MinAmount`,`MinSku`,`MinQty`,`Pack`,`DiscBaht`,`DiscPerAmount`,`DiscPerQty`,`DiscPer1`,`DiscPer2`,`DiscPer3`,`FreeType`,`FreeProductOrGrpId`,`FreeQty`,`FreePack`,`FreePerAmount`,`FreePerQty`,`FreeBaht`,`Formula`,`UpdateAt`) VALUES
('M','M4','2012-08-01','2013-12-30','group','B','1100','0','0','','5','100','0','0','0','0','G','A','1','กระป๋อง','100','0','0','F','2013-08-25 21:13:24');



-- -------------------------------------------
-- TABLE DATA SaleArea
-- -------------------------------------------
INSERT INTO `SaleArea` (`AreaId`,`AreaName`,`SupervisorId`) VALUES
('N1','พื้นที่เหนือ 1','S001');
INSERT INTO `SaleArea` (`AreaId`,`AreaName`,`SupervisorId`) VALUES
('N2','พื้นที่เหนือ 2','S002');
INSERT INTO `SaleArea` (`AreaId`,`AreaName`,`SupervisorId`) VALUES
('N3','พื้นที่เหนือ 3','S003');
INSERT INTO `SaleArea` (`AreaId`,`AreaName`,`SupervisorId`) VALUES
('N4','พื้นที่เหนือ 4','S004');
INSERT INTO `SaleArea` (`AreaId`,`AreaName`,`SupervisorId`) VALUES
('N5','พื้นที่เหนือ 5','S005');



-- -------------------------------------------
-- TABLE DATA SaleUnit
-- -------------------------------------------
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N001','หน่วยขายเหนือ 1','เครดิต','E001','N1');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N002','หน่วยขายเหนือ 2','หน่วยรถ','E002','N1');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N003','หน่วยขายเหนือ 3','หน่วยรถ','E003','N1');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N004','หน่วยขายเหนือ 4','หน่วยรถ','E004','N1');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N005','หน่วยขายเหนือ 5','หน่วยรถ','E005','N1');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N006','หน่วยขายเหนือ 6','หน่วยรถ','E006','N2');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N007','หน่วยขายเหนือ 7','หน่วยรถ','E007','N2');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N008','หน่วยขายเหนือ 8','หน่วยรถ','E008','N2');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N009','หน่วยขายเหนือ 9','หน่วยรถ','E009','N2');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N010','หน่วยขายเหนือ 10','หน่วยรถ','E010','N2');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N011','หน่วยขายเหนือ 11','หน่วยรถ','E011','N3');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N012','หน่วยขายเหนือ 12','หน่วยรถ','E012','N3');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N013','หน่วยขายเหนือ 13','หน่วยรถ','E013','N3');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N014','หน่วยขายเหนือ 14','หน่วยรถ','E014','N3');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N015','หน่วยขายเหนือ 15','หน่วยรถ','E015','N3');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N016','หน่วยขายเหนือ 16','หน่วยรถ','E016','N4');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N017','หน่วยขายเหนือ 17','หน่วยรถ','E017','N4');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N018','หน่วยขายเหนือ 18','หน่วยรถ','E018','N4');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N019','หน่วยขายเหนือ 19','หน่วยรถ','E019','N4');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N020','หน่วยขายเหนือ 20','หน่วยรถ','E020','N4');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N021','หน่วยขายเหนือ 21','หน่วยรถ','E021','N5');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N022','หน่วยขายเหนือ 22','หน่วยรถ','E022','N5');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N023','หน่วยขายเหนือ 23','หน่วยรถ','E023','N5');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N024','หน่วยขายเหนือ 24','หน่วยรถ','E024','N5');
INSERT INTO `SaleUnit` (`SaleId`,`SaleName`,`SaleType`,`EmployeeId`,`AreaId`) VALUES
('N025','หน่วยขายเหนือ 25','หน่วยรถ','E025','N5');



-- -------------------------------------------
-- TABLE DATA Stock
-- -------------------------------------------
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0010100001','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0010200001','20','0','0','0','20','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0010300001','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0010400001','20','0','0','0','20','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0050100001','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0050100002','20','0','0','0','20','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0050100003','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0050100004','20','0','0','0','20','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N002','0050100005','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0010100001','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0010200001','20','0','0','0','20','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0010300001','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0010400001','20','0','0','0','20','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0050100001','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0050100002','20','0','0','0','20','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0050100003','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0050100004','20','0','0','0','20','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');
INSERT INTO `Stock` (`SaleId`,`ProductId`,`StartQtyLevel1`,`StartQtyLevel2`,`StartQtyLevel3`,`StartQtyLevel4`,`CurrentQtyLevel1`,`CurrentQtyLevel2`,`CurrentQtyLevel3`,`CurrentQtyLevel4`,`BadQtyLevel1`,`BadQtyLevel2`,`BadQtyLevel3`,`BadQtyLevel4`,`MidInQtyLevel1`,`MidInQtyLevel2`,`MidInQtyLevel3`,`MidInQtyLevel4`,`ReturnQtyLevel1`,`ReturnQtyLevel2`,`ReturnQtyLevel3`,`ReturnQtyLevel4`,`ReplaceQtyLevel1`,`ReplaceQtyLevel2`,`ReplaceQtyLevel3`,`ReplaceQtyLevel4`,`SaleQtyLevel1`,`SaleQtyLevel2`,`SaleQtyLevel3`,`SaleQtyLevel4`,`FreeQtyLevel1`,`FreeQtyLevel2`,`FreeQtyLevel3`,`FreeQtyLevel4`,`MidOutQtyLevel1`,`MidOutQtyLevel2`,`MidOutQtyLevel3`,`MidOutQtyLevel4`,`EndQtyLevel1`,`EndQtyLevel2`,`EndQtyLevel3`,`EndQtyLevel4`,`UpdateAt`) VALUES
('N003','0050100005','10','0','0','0','10','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA StockCheckList
-- -------------------------------------------
INSERT INTO `StockCheckList` (`SaleId`,`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`UpdateAt`) VALUES
('N001','309','144','','','2013-08-25 21:13:23');
INSERT INTO `StockCheckList` (`SaleId`,`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`UpdateAt`) VALUES
('N001','313','167','','0050100001','2013-08-25 21:13:23');
INSERT INTO `StockCheckList` (`SaleId`,`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`UpdateAt`) VALUES
('N002','309','144','','','2013-08-25 21:13:23');
INSERT INTO `StockCheckList` (`SaleId`,`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`UpdateAt`) VALUES
('N002','313','167','','0050100001','2013-08-25 21:13:23');
INSERT INTO `StockCheckList` (`SaleId`,`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`UpdateAt`) VALUES
('N003','309','144','','','2013-08-25 21:13:23');
INSERT INTO `StockCheckList` (`SaleId`,`GrpLevel1Id`,`GrpLevel2Id`,`GrpLevel3Id`,`ProductId`,`UpdateAt`) VALUES
('N003','313','167','','0050100001','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA TargetSale
-- -------------------------------------------
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N001','all','','20000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N001','l1','313','10000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N001','l2','167','10000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N001','sku','0050100001','5000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N001','sku','0050100002','0','10','หีบ','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N002','all','','20000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N002','l1','313','10000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N002','l2','167','10000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N002','sku','0050100001','5000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N002','sku','0050100002','0','10','หีบ','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N003','all','','20000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N003','l1','313','10000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N003','l2','167','10000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N003','sku','0050100001','5000','0','','2013-08-25 21:13:24');
INSERT INTO `TargetSale` (`SaleId`,`Level`,`ProductOrGrpId`,`TargetAmount`,`TargetQty`,`TargetPack`,`UpdateAt`) VALUES
('N003','sku','0050100002','0','10','หีบ','2013-08-25 21:13:24');



-- -------------------------------------------
-- TABLE DATA Trip
-- -------------------------------------------
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('1','วันจันทร์');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('2','วันอังคาร');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('3','วันพุธ');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('4','วันพฤหัส');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('5','วันศุกร์');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('6','วันเสาร์');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('7','วันอาทิตย์');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('8','วันที่ 1');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('9','วันที่ 2');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('10','วันที่ 3');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('11','วันที่ 4');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('12','วันที่ 5');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('13','วันที่ 6');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('14','วันที่ 7');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('15','วันที่ 8');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('16','วันที่ 9');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('17','วันที่ 10');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('18','วันที่ 11');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('19','วันที่ 12');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('20','วันที่ 13');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('21','วันที่ 14');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('22','วันที่ 15');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('23','วันที่ 16');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('24','วันที่ 17');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('25','วันที่ 18');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('26','วันที่ 19');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('27','วันที่ 20');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('28','วันที่ 21');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('29','วันที่ 22');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('30','วันที่ 23');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('31','วันที่ 24');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('32','วันที่ 25');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('33','วันที่ 26');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('34','วันที่ 27');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('35','วันที่ 28');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('36','วันที่ 29');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('37','วันที่ 30');
INSERT INTO `Trip` (`TripId`,`TripName`) VALUES
('38','วันที่ 31');



-- -------------------------------------------
-- TABLE DATA User
-- -------------------------------------------
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('1','admin','1a3b0cc7ede95099129197b513be8bee','System Administrator','admin','');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('2','manager','1a3b0cc7ede95099129197b513be8bee','Test System Manager','manager','');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('3','staff','1a3b0cc7ede95099129197b513be8bee','Test Administrative Staff','user','');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('4','supervisor','1a3b0cc7ede95099129197b513be8bee','Test Supervisor','user','');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('5','employee','1a3b0cc7ede95099129197b513be8bee','Test employee','user','');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('6','sup1','1a3b0cc7ede95099129197b513be8bee','Supervisor 1','user','S001');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('7','sup2','1a3b0cc7ede95099129197b513be8bee','Supervisor 2','user','S002');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('8','sup3','1a3b0cc7ede95099129197b513be8bee','Supervisor 3','user','S003');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('9','sup4','1a3b0cc7ede95099129197b513be8bee','Supervisor 4','user','S004');
INSERT INTO `User` (`id`,`username`,`password`,`name`,`role`,`employee`) VALUES
('10','sup5','1a3b0cc7ede95099129197b513be8bee','Supervisor 5','user','S005');



-- -------------------------------------------
-- TABLE DATA Warehouse
-- -------------------------------------------
INSERT INTO `Warehouse` (`WarehouseId`,`WarehouseName`,`WarehouseType`,`UpdateAt`) VALUES
('C1','หน่วยรถ 1','คลังรถ','2013-08-25 21:13:23');
INSERT INTO `Warehouse` (`WarehouseId`,`WarehouseName`,`WarehouseType`,`UpdateAt`) VALUES
('C2','หน่วยรถ 2','คลังรถ','2013-08-25 21:13:23');
INSERT INTO `Warehouse` (`WarehouseId`,`WarehouseName`,`WarehouseType`,`UpdateAt`) VALUES
('C3','หน่วยรถ 3','คลังรถ','2013-08-25 21:13:23');
INSERT INTO `Warehouse` (`WarehouseId`,`WarehouseName`,`WarehouseType`,`UpdateAt`) VALUES
('W1','คลัง 1','คลังใหญ่','2013-08-25 21:13:23');
INSERT INTO `Warehouse` (`WarehouseId`,`WarehouseName`,`WarehouseType`,`UpdateAt`) VALUES
('W2','คลัง 2','คลังใหญ่','2013-08-25 21:13:23');
INSERT INTO `Warehouse` (`WarehouseId`,`WarehouseName`,`WarehouseType`,`UpdateAt`) VALUES
('W3','คลัง 3','คลังใหญ่','2013-08-25 21:13:23');



-- -------------------------------------------
-- TABLE DATA tbl_migration
-- -------------------------------------------
INSERT INTO `tbl_migration` (`version`,`apply_time`) VALUES
('m000000_000000_base','1376719738');
INSERT INTO `tbl_migration` (`version`,`apply_time`) VALUES
('m130415_111600_create_tables','1377440004');



-- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
COMMIT;
-- -------------------------------------------
-- -------------------------------------------
-- END BACKUP
-- -------------------------------------------
