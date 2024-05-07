CREATE TABLE `kussin_article_data_enhancer` (
	`ProductNumber` VARCHAR(255) NOT NULL COMMENT 'Artikelnummer (SKU) (oxarticles__oxartnum)' COLLATE 'utf8_unicode_ci',
	`VendorCode` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`EAN` VARCHAR(128) NULL DEFAULT '' COMMENT 'International Article Number (EAN)' COLLATE 'utf8_unicode_ci',
	`Data` LONGTEXT NOT NULL COMMENT 'JSON Vendor Data' COLLATE 'utf8_unicode_ci',
	`DateInsert` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`DateModified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	UNIQUE INDEX `VendorId` (`ProductNumber`, `VendorCode`) USING BTREE
)
COMMENT='#60886 WMDK FF Queue Addtional Vendor Data'
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
ROW_FORMAT=DYNAMIC
;
