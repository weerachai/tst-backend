<?php

class m130415_111600_create_tables extends CDbMigration
{
  public function safeUp()
  {

    $this->reset();
    
    $TESTING = true;
    
    /* table prefix
     * b - table for backend data
     * s - table to be synchronized
     * f - table for storing frontend data
     * o - table for paramter option
     * c - table for device config
     */

    // System User Management Tables
    $this->createTable('User', 
                       array(
                             'id' => 'pk',
                             'username' => 'string not null unique',
                             'password' => 'string not null',
                             'name' => 'string',
                             'role' => 'string',
                             'employee' => 'string'
                             ), 'ENGINE=InnoDB');
    $this->addForeignKey("fk_User_AuthItem", "User", "role", "AuthItem", "name", "RESTRICT", "CASCADE");
    $this->addForeignKey("fk_User_bEmployee", "User", "employee", "bEmployee", "EmployeeId", "SET NULL", "CASCADE");

    $pass = md5('1234');
    $this->execute("INSERT INTO User VALUES(1,'admin','$pass','Test Administrator','admin',null)");

    $this->createTable('AuthItem', 
                       array(
                             'name' => 'string',
                             'type' => 'integer not null',
                             'description' => 'text',
                             'bizrule' => 'text',
                             'data' => 'text',
                             'PRIMARY KEY (name)',
                             ), 'ENGINE=InnoDB');
    $this->execute("INSERT INTO AuthItem VALUES('admin',2,'Administrator',null,'N;')");
    $this->execute("INSERT INTO AuthItem VALUES('manager',2,'System Manager',null,'N;')");
    $this->execute("INSERT INTO AuthItem VALUES('user',2,'User','return !Yii::app()->user->isGuest;','N;')");
    $this->execute("INSERT INTO AuthItem VALUES('updateSelf',1,'Update own information','return Yii::app()->user->id==".'$'."params;','N;')");

    $this->createTable('AuthItemChild', 
                       array(
                             'parent' => 'string not null',
                             'child' => 'string not null',
                             'PRIMARY KEY (parent, child)',
                             ), 'ENGINE=InnoDB');
    $this->addForeignKey("fk_AuthItemChild_AuthItem1", "AuthItemChild", "parent", "AuthItem", "name", "CASCADE", "CASCADE");
    $this->addForeignKey("fk_AuthItemChild_AuthItem2", "AuthItemChild", "child", "AuthItem", "name", "CASCADE", "CASCADE");

    $this->execute("INSERT INTO AuthItemChild VALUES('admin','manager')");
    $this->execute("INSERT INTO AuthItemChild VALUES('manager','user')");
    $this->execute("INSERT INTO AuthItemChild VALUES('user','updateSelf')");

    $this->createTable('AuthAssignment', 
                       array(
                             'itemname' => 'string not null',
                             'userid' => 'integer not null',
                             'bizrule' => 'text',
                             'data' => 'text',
                             ), 'ENGINE=InnoDB');
    $this->addForeignKey("fk_AuthAssignment_AuthItem", "AuthAssignment", "itemname", "AuthItem", "name", "RESTRICT", "CASCADE");
    $this->addForeignKey("fk_AuthAssignment_User", "AuthAssignment", "userid", "User", "id", "CASCADE", "CASCADE");

    $this->execute("INSERT INTO AuthAssignment VALUES('admin','1',null,'N;')");

if ($TESTING) {
    $this->execute("INSERT INTO User VALUES(2,'manager','$pass','Test System Manager','manager',null)");
    $this->execute("INSERT INTO User VALUES(3,'user','$pass','Test User','user',null)");
    $this->execute("INSERT INTO AuthAssignment VALUES('manager','2',null,'N;')");
    $this->execute("INSERT INTO AuthAssignment VALUES('user','3',null,'N;')");
}



    // Business data
    $this->createTable('bConfig', // backend config information
                       array(
                             'DayToClear' => 'integer not null',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');
    $this->execute("INSERT INTO bConfig VALUES(60,now())");

    $this->createTable('bEmployee', // employee information
                       array(
                             'EmployeeId' => 'string',
                             'FirstName' => 'string not null',
                             'LastName' => 'string not null',
                             'Status' => 'string',
                             'primary key (EmployeeId)',
                             ), 'ENGINE=InnoDB');	

    $this->createTable('bSaleArea', // sale area information
                       array(
                             'AreaId' => 'string',
                             'AreaName' => 'string not null',
                             'Province' => 'string',
                             'District' => 'string',
                             'SubDistrict' => 'string',
                             'SupervisorId' => 'string',
                             'primary key (AreaId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_bSaleArea_bEmployee','bSaleArea','SupervisorId','bEmployee','EmployeeId','SET NULL','CASCADE');

    $this->createTable('sDevice', // device information
                       array(
                             'DeviceId' => 'string',
                             'DeviceKey' => 'string',
                             'SaleId' => 'string',
                             'Username' => 'string',
                             'Password' => 'string',
                             'primary key (DeviceId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_sDevice_bSaleUnit','sDevice','SaleId','bSaleUnit','SaleId','SET NULL','CASCADE');

    $this->createTable('bSaleUnit', // sale unit information
                       array(
                             'SaleId' => 'string',
                             'SaleName' => 'string not null',
                             'SaleType' => 'string',
                             'EmployeeId' => 'string',
                             'AreaId' => 'string',
                             'Active' => 'string',
                             'primary key (SaleId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_bSaleUnit_bEmployee','bSaleUnit','EmployeeId','bEmployee','EmployeeId','SET NULL','CASCADE');
    $this->addForeignKey('fk_bSaleUnit_bSaleArea','bSaleUnit','AreaId','bSaleArea','AreaId','SET NULL','CASCADE');

if ($TESTING) {
    $k = 0;    
    for ($i = 1; $i <= 5; $i++) {
        $area = $i+3;
        $supervisor = sprintf("S%03d", $i);
        $this->execute("INSERT INTO User VALUES($area,'sup$i','$pass','Supervisor $i','user','$supervisor')");
        $this->execute("INSERT INTO AuthAssignment VALUES('user',$area,null,'N;')");
        $this->execute("INSERT INTO bEmployee VALUES('$supervisor','นายซุป $i','นามสกุลซุป $i','ทำงาน')");
        $this->execute("INSERT INTO bSaleArea VALUES('N$i','พื้นที่เหนือ $i','','','','$supervisor')");
        for ($j = 1; $j <= 5; $j++) {
            $k++;
            $sale = sprintf("N%03d", $k);
            $device = sprintf("D%03d", $k);
            $employee = sprintf("E%03d", $k);
    
            $this->execute("INSERT INTO bEmployee VALUES('$employee','นายสมมติ $k','นามสกุลสมมติ $k','ทำงาน')");
            $this->execute("INSERT INTO sDevice VALUES('$device','','$sale','$device','$pass')");
            $this->execute("INSERT INTO bSaleUnit VALUES('$sale','หน่วยขายเหนือ $k','เครดิต','$employee','N$i','Y')");
        }
    }
}

    $this->createTable('cDeviceSetting', // device setting
                       array(
                             'SaleId' => 'string',
                             'PromotionSku' => 'string', 
                             'PromotionGroup' => 'string', 
                             'PromotionBill' => 'string',
                             'PromotionAccu' => 'string', 
                             'Vat' => 'string', // vat calculation method - bill,sku
                             'OverStock' => 'char', // stock limit sale - Y, N
                             'DayToClear' => 'integer', // day to clear data
                             'UpdateAt' => 'datetime',			
                             'primary key (SaleId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_cDeviceSetting_bSaleUnit','cDeviceSetting','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO cDeviceSetting VALUES('S001','A','M','B','AC','sku','Y',60,now())");
}
    
    $this->createTable('oControlRunning', // control running option - mutable
                       array(
                             'ControlId' => 'string',
                             'ControlName' => 'string not null',
                             'Prefix' => 'string not null',
                             'UpdateAt' => 'datetime',          
                             'primary key (ControlId)',
                             ), 'ENGINE=InnoDB');   

if ($TESTING) {
    $this->execute("INSERT INTO oControlRunning VALUES('C01','Sale Order','SO',now())");
    $this->execute("INSERT INTO oControlRunning VALUES('C02','Invoice','IN',now())");
    $this->execute("INSERT INTO oControlRunning VALUES('C03','รับคืนสินค้า','RE',now())");
    $this->execute("INSERT INTO oControlRunning VALUES('C04','เปลี่ยนสินค้า','EX',now())");
    $this->execute("INSERT INTO oControlRunning VALUES('C05','ใบเบิกสินค้า','RQ',now())");
    $this->execute("INSERT INTO oControlRunning VALUES('C06','ใบส่งสินค้า','SN',now())");
    $this->execute("INSERT INTO oControlRunning VALUES('C07','ใบรับสินค้า','RC',now())");
    $this->execute("INSERT INTO oControlRunning VALUES('C08','รหัสร้านค้า','CU',now())");
}

    $this->createTable('sControlNo', // control number for each device 
                       array(
                             'DeviceId' => 'string',
                             'ControlId' => 'string',
                             'Year' => 'integer',
                             'Month' => 'integer',
                             'No' => 'integer',
                             'UpdateAt' => 'datetime',			
                             'primary key (DeviceId, ControlId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_sControlNo_sDevice','sControlNo','DeviceId','sDevice','DeviceId','CASCADE','CASCADE');
    $this->addForeignKey('fk_sControlNo_oControlRunning','sControlNo','ControlId','oControlRunning','ControlId','RESTRICT','CASCADE');

if ($TESTING) {
    $year = date("y");
    $month = date("m");
    $this->execute("INSERT INTO sControlNo VALUES('D001','C01',$year,$month,1,now())");
    $this->execute("INSERT INTO sControlNo VALUES('D001','C02',$year,$month,1,now())");
    $this->execute("INSERT INTO sControlNo VALUES('D001','C03',$year,$month,1,now())");
    $this->execute("INSERT INTO sControlNo VALUES('D001','C04',$year,$month,1,now())");
    $this->execute("INSERT INTO sControlNo VALUES('D001','C05',$year,$month,1,now())");
    $this->execute("INSERT INTO sControlNo VALUES('D001','C06',$year,$month,1,now())");
    $this->execute("INSERT INTO sControlNo VALUES('D001','C07',$year,$month,1,now())");
}

    $this->createTable('oTrip', // trip option - fixed
                       array(
                             'TripId' => 'pk',
                             'TripName' => 'string not null unique',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');	
    
    $this->execute("INSERT INTO oTrip VALUES(1,'วันจันทร์',now())");
    $this->execute("INSERT INTO oTrip VALUES(2,'วันอังคาร',now())");
    $this->execute("INSERT INTO oTrip VALUES(3,'วันพุธ',now())");
    $this->execute("INSERT INTO oTrip VALUES(4,'วันพฤหัส',now())");
    $this->execute("INSERT INTO oTrip VALUES(5,'วันศุกร์',now())");
    $this->execute("INSERT INTO oTrip VALUES(6,'วันเสาร์',now())");
    $this->execute("INSERT INTO oTrip VALUES(7,'วันอาทิตย์',now())");
    for ($i = 1; $i <= 31; $i++)
      $this->execute("INSERT INTO oTrip(TripName,UpdateAt) VALUES('วันที่ $i',now())");

    $this->createTable('cSaleHistory', // generate sale history sent to device
                       array(
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'ProductId' => 'string',
                             'SaleAvg' => 'string',
                             'M01' => 'string',
                             'M02' => 'string',
                             'M03' => 'string',
                             'M04' => 'string',
                             'M05' => 'string',
                             'M06' => 'string',
                             'M07' => 'string',
                             'M08' => 'string',
                             'M09' => 'string',
                             'M10' => 'string',
                             'M11' => 'string',
                             'M12' => 'string',
                             'UpdateAt' => 'datetime',          
                             'primary key (SaleId, CustomerId, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_cSaleHistory_bSaleUnit','cSaleHistory','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');

    $this->createTable('oLocation', 
                       array(
                             'LocationId' => 'string',
                             'Province' => 'string',
                             'District' => 'string',
                             'SubDistrict' => 'string',
                             'ZipCode' => 'string',
                             'UpdateAt' => 'datetime',
                             'primary key (LocationId)',
                             ), 'ENGINE=InnoDB');   

    if (FALSE && ($handle = fopen(dirname(__FILE__).'/Location.csv', "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $this->execute("INSERT INTO oLocation VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]',now())");
        }
        fclose($handle);
    }
        
    $this->createTable('oCustomerTitle', 
                       array(
                             'TitleId' => 'pk',
                             'TitleName' => 'string not null UNIQUE',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');	
    $this->execute("INSERT INTO oCustomerTitle VALUES(1,'บม.จ.',now())");
    $this->execute("INSERT INTO oCustomerTitle VALUES(2,'ร้าน',now())");
    
    $this->createTable('cStockCheckList', 
                       array(
                             'id' => 'pk',
                             'SaleId' => 'string',
                             'GrpLevel1Id' => 'string',
                             'GrpLevel2Id' => 'string',
                             'GrpLevel3Id' => 'string',
                             'ProductId' => 'string',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_cStockCheckList_bSaleUnit','cStockCheckList','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');
    $this->addForeignKey('fk_cStockCheckList_oGrpLevel1','cStockCheckList','GrpLevel1Id','oGrpLevel1','GrpLevel1Id','CASCADE','CASCADE');
    $this->addForeignKey('fk_cStockCheckList_oGrpLevel2','cStockCheckList','GrpLevel2Id','oGrpLevel2','GrpLevel2Id','CASCADE','CASCADE');
    $this->addForeignKey('fk_cStockCheckList_oGrpLevel3','cStockCheckList','GrpLevel3Id','oGrpLevel3','GrpLevel3Id','CASCADE','CASCADE');
    $this->addForeignKey('fk_cStockCheckList_oProduct','cStockCheckList','ProductId','oProduct','ProductId','CASCADE','CASCADE');

    $this->execute("INSERT INTO cStockCheckList VALUES(1,'N001','309','144',null,'',now())");
    $this->execute("INSERT INTO cStockCheckList VALUES(2,'N001','313','167',null,'0050100001',now())");
    $this->execute("INSERT INTO cStockCheckList VALUES(3,'N001','309','144',null,'',now())");
    $this->execute("INSERT INTO cStockCheckList VALUES(4,'N001','313','167',null,'0050100001',now())");
    
    $this->createTable('fStockCheck', 
                       array(
                             'SaleId' => 'string',                        
                             'CheckDate' => 'date',
                             'CustomerId' => 'string',
                             'ProductId' => 'string',
                             'FrontQtyLevel1' => 'integer',
                             'FrontQtyLevel2' => 'integer',
                             'FrontQtyLevel3' => 'integer',
                             'FrontQtyLevel4' => 'integer',
                             'BackQtyLevel1' => 'integer',
                             'BackQtyLevel2' => 'integer',
                             'BackQtyLevel3' => 'integer',
                             'BackQtyLevel4' => 'integer',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (CheckDate, CustomerId, ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_fStockCheck_bSaleUnit','fStockCheck','SaleId','bSaleUnit','SaleId','SET NULL','CASCADE');
    $this->addForeignKey('fk_fStockCheck_sCustomer','fStockCheck','CustomerId','sCustomer','CustomerId','CASCADE','CASCADE');
    $this->addForeignKey('fk_fStockCheck_oProduct','fStockCheck','ProductId','oProduct','ProductId','CASCADE','CASCADE');
   
    $this->createTable('oGrpLevel1', 
                       array(
                             'GrpLevel1Id' => 'string',
                             'GrpLevel1Name' => 'string not null UNIQUE',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (GrpLevel1Id)',
                             ), 'ENGINE=InnoDB');   
if ($TESTING) {
    $this->execute("INSERT INTO oGrpLevel1 VALUES('306','GUNDAM',now())");
    $this->execute("INSERT INTO oGrpLevel1 VALUES('309','COOK',now())");
    $this->execute("INSERT INTO oGrpLevel1 VALUES('312','NECTRA',now())");
    $this->execute("INSERT INTO oGrpLevel1 VALUES('313','SEALECT',now())");
}

    $this->createTable('oGrpLevel2', 
                       array(
                             'GrpLevel1Id' => 'string not null',
                             'GrpLevel2Id' => 'string',
                             'GrpLevel2Name' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (GrpLevel2Id)',
                             ), 'ENGINE=InnoDB');   
    
    $this->execute("INSERT INTO oGrpLevel2 VALUES('306','190','ข้าวโพดอบกรอบฮิโรชิกันดั้ม',now())");
    $this->execute("INSERT INTO oGrpLevel2 VALUES('309','144','น้ำมันพืชกุ๊กขวด',now())");
    $this->execute("INSERT INTO oGrpLevel2 VALUES('309','145','น้ำมันพืชกุ๊กปี๊ป',now())");
    $this->execute("INSERT INTO oGrpLevel2 VALUES('312','186','ผลิตภัณฑ์ตราเน็กตร้า',now())");
    $this->execute("INSERT INTO oGrpLevel2 VALUES('313','167','ทูน่า-ซีเล็ก',now())");
    $this->execute("INSERT INTO oGrpLevel2 VALUES('313','168','ซีเล็กในซอสมะเขือเทศ',now())");
    
if ($TESTING) {
    $this->createTable('oGrpLevel3', 
                       array(
                             'GrpLevel2Id' => 'string not null',
                             'GrpLevel3Id' => 'string',
                             'GrpLevel3Name' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (GrpLevel3Id)',
                             ), 'ENGINE=InnoDB');   
}

    $this->createTable('oProduct', 
                       array(
                             'GrpLevel1Id' => 'string not null',
                             'GrpLevel2Id' => 'string',
                             'GrpLevel3Id' => 'string',
                             'ProductId' => 'string',
                             'ProductName' => 'string not null',
                             'PackLevel1' => 'string',
                             'PackLevel2' => 'string',
                             'PackLevel3' => 'string',
                             'PackLevel4' => 'string',
                             'PriceLevel1' => 'decimal(10,2)',
                             'PriceLevel2' => 'decimal(10,2)',
                             'PriceLevel3' => 'decimal(10,2)',
                             'PriceLevel4' => 'decimal(10,2)',
                             'FreeFlag' => 'char',
                             'VatFlag' => 'char',
                             'ShipFlag' => 'char',
                             'MinShip' => 'decimal(10,2)',
                             'ShipFee' => 'decimal(10,2)',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_oProduct_oGrpLevel1','oProduct','GrpLevel1Id','oGrpLevel1','GrpLevel1Id','RESTRICT','CASCADE');
    $this->addForeignKey('fk_oProduct_oGrpLevel2','oProduct','GrpLevel2Id','oGrpLevel2','GrpLevel2Id','SET NULL','CASCADE');
    $this->addForeignKey('fk_oProduct_oGrpLevel3','oProduct','GrpLevel3Id','oGrpLevel3','GrpLevel3Id','SET NULL','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('309','144',null,'0010100001','น้ำมันกุ๊กถั่วเหลือง 1/4 ลิตร','หีบ','','','',614.37,0,0,0,'N','Y','N',0,0,now())");
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('309','144',null,'0010200001','น้ำมันกุ๊กถั่วเหลือง 1/2 ลิตร','หีบ','','','',555.77,0,0,0,'N','Y','N',0,0,now())");
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('309','144',null,'0010300001','น้ำมันกุ๊กทานตะวัน 1/2 ลิตร','หีบ','','','',913.89,0,0,0,'N','Y','N',0,0,now())");
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('309','144',null,'0010400001','น้ำมันกุ๊กถั่วเหลือง 1 ลิตร','หีบ','','','',525.39,0,0,0,'N','Y','N',0,0,now())");
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('313','167',null,'0050100001','ซีเล็กแซนวิชน้ำมัน 185 กรัม','หีบ','','','กระป๋อง',1284,0,0,0,'N','Y','N',0,0,now())");
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('313','167',null,'0050100002','ซีเล็กแซนวิชน้ำเกลือ 185 กรัม','หีบ','','','กระป๋อง',1284,0,0,0,'N','Y','N',0,0,now())");
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('313','167',null,'0050100003','ซีเล็กแซนวิชน้ำมัน 185 กรัม แพ็ค 4','หีบ','กล่อง','','กระป๋อง',1284,200,0,0,'N','Y','N',0,0,now())");
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('313','167',null,'0050100004','ซีเล็กแซนวิชน้ำเปล่า 185 กรัม','หีบ','กล่อง','โหล','กระป๋อง',1284,200,50,0,'N','Y','N',0,0,now())");
    $this->execute("INSERT INTO oProduct VALUES"
                   . "('313','167',null,'0050100005','ซีเล็กแซนวิชน้ำแร่ 185 กรัม','หีบ','กล่อง','โหล','กระป๋อง',1284,200,50,5,'N','Y','N',0,0,now())");
}

    $this->createTable('sStock', 
                       array(
                             'SaleId' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer',
                             'QtyLevel2' => 'integer',
                             'QtyLevel3' => 'integer',
                             'QtyLevel4' => 'integer',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (SaleId, ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_sStock_bSaleUnit','sStock','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');
    $this->addForeignKey('fk_sStock_oProduct','sStock','ProductId','oProduct','ProductId','RESTRICT','CASCADE');

    $this->createTable('fProductOrder', 
                       array(
                             'OrderNo' => 'string',
                             'OrderType' => 'string',
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'OrderDate' => 'datetime',
                             'Total' => 'decimal(20,2)',
                             'Vat' => 'decimal(20,2)',
                             'Discount' => 'decimal(20,2)',
                             'DeliverDate' => 'date',
                             'DeliverAddress' => 'text',
                             'PaymentType' => 'string',
                             'Status' => 'string',
                             'Remark' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_fProductOrder_bSaleUnit','fProductOrder','SaleId','bSaleUnit','SaleId','SET NULL','CASCADE');
    $this->addForeignKey('fk_fProductOrder_sCustomer','fProductOrder','CustomerId','sCustomer','CustomerId','RESTRICT','CASCADE');
     
    $this->createTable('fOrderDetail',
                       array(
                             'OrderNo' => 'string',
                             'ProductId' => 'string',
                             'BuyLevel1' => 'integer',
                             'BuyLevel2' => 'integer',
                             'BuyLevel3' => 'integer',
                             'BuyLevel4' => 'integer',
                             'PriceLevel1' => 'decimal(10,2)',
                             'PriceLevel2' => 'decimal(10,2)',
                             'PriceLevel3' => 'decimal(10,2)',
                             'PriceLevel4' => 'decimal(10,2)',
                             'PromotionAccuId' => 'string',
                             'PromotionAccuType' => 'string',
                             'PromotionDate' => 'date',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo, ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_fOrderDetail_fProductOrder','fOrderDetail','OrderNo','fProductOrder','OrderNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_fOrderDetail_oProduct','fOrderDetail','ProductId','oProduct','ProductId','RESTRICT','CASCADE');
 
    $this->createTable('fProductReturn', 
                       array(
                             'ReturnNo' => 'string',
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'ReturnDate' => 'date',
                             'Total' => 'decimal(20,2)',
                             'Vat' => 'decimal(20,2)',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ReturnNo)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_fProductReturn_bSaleUnit','fProductReturn','SaleId','bSaleUnit','SaleId','SET NULL','CASCADE');
    $this->addForeignKey('fk_fProductReturn_sCustomer','fProductReturn','CustomerId','sCustomer','CustomerId','RESTRICT','CASCADE');

    $this->createTable('fReturnDetail', 
                       array(
                             'ReturnNo' => 'string',
                             'ProductId' => 'string',
                             'MfgDate' => 'date',
                             'ExpDate' => 'date',
                             'LotNo' => 'string',
                             'OrderNo' => 'string',
                             'Reason' => 'string',
                             'Condition' => 'string',
                             'QtyLevel1' => 'integer',
                             'QtyLevel2' => 'integer',
                             'QtyLevel3' => 'integer',
                             'QtyLevel4' => 'integer',
                             'PriceLevel1' => 'decimal(10,2)',
                             'PriceLevel2' => 'decimal(10,2)',
                             'PriceLevel3' => 'decimal(10,2)',
                             'PriceLevel4' => 'decimal(10,2)',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ReturnNo, ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_fReturnDetail_fProductReturn','fReturnDetail','ReturnNo','fProductReturn','ReturnNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_fReturnDetail_oProduct','fReturnDetail','ProductId','oProduct','ProductId','RESTRICT','CASCADE');

    $this->createTable('fFreeDetail', 
                       array(
                             'OrderNo' => 'string',
                             'PromotionId' => 'string',
                             'FreeProductId' => 'string',
                             'FreePack' => 'string',
                             'FreePrice' => 'decimal(10,2)',
                             'FreeQty' => 'integer',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo, PromotionId, FreeProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_fFreeDetail_fProductOrder','fFreeDetail','OrderNo','fProductOrder','OrderNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_fFreeDetail_oPromotion','fFreeDetail','PromotionId','oPromotion','PromotionId','RESTRICT','CASCADE');
    $this->addForeignKey('fk_fFreeDetail_oProduct','fFreeDetail','FreeProductId','oProduct','ProductId','RESTRICT','CASCADE');

    $this->createTable('fDiscDetail', 
                       array(
                             'OrderNo' => 'string',
                             'PromotionId' => 'string',
                             'DiscBaht' => 'decimal(20,2)',
                             'DiscPer1' => 'integer',
                             'DiscPer2' => 'integer',
                             'DiscPer3' => 'integer',
                             'DiscTotal' => 'decimal(20,2)',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo, PromotionId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_fDiscDetail_fProductOrder','fDiscDetail','OrderNo','fProductOrder','OrderNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_fDiscDetail_oPromotion','fDiscDetail','PromotionId','oPromotion','PromotionId','RESTRICT','CASCADE');


    $this->createTable('oPromotion', 
                       array(
                             'PromotionGroup' => 'string',
                             'PromotionId' => 'string',
                             'StartDate' => 'date',
                             'EndDate' => 'date',
                             'PromotionType' => 'string',
                             'ProductOrGrpId' => 'string',
                             'MinAmount' => 'integer',
                             'MinSku' => 'integer',
                             'MinQty' => 'integer',
                             'Pack' => 'string',
                             'DiscBaht' => 'integer',
                             'DiscPerAmount' => 'integer',
                             'DiscPerQty' => 'integer',
                             'DiscPer1' => 'integer',
                             'DiscPer2' => 'integer',
                             'DiscPer3' => 'integer',
                             'FreeType' => 'string',
                             'FreeProductOrGrpId' => 'string',
                             'FreeQty' => 'integer',
                             'FreePack' => 'string',
                             'FreePerAmount' => 'integer',
                             'FreePerQty' => 'integer',
                             'FreeBaht' => 'integer',
                             'Formula' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (PromotionId)',
                             ), 'ENGINE=InnoDB');	

if ($TESTING) {
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A1','2012-08-01','2013-12-30','sku','0050100003',0,0,1,'หีบ',5,0,1,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A2','2012-08-01','2013-12-30','sku','0050100003',0,0,11,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A3','2012-08-01','2013-12-30','sku','0050100003',0,0,21,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A4','2012-08-01','2013-12-30','sku','0050100003',0,0,31,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A5','2012-08-01','2013-12-30','sku','0050100003',0,0,41,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A6','2012-08-01','2013-12-30','sku','0050100003',0,0,51,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A8','2012-08-01','2013-12-30','sku','0050100001',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A9','2012-08-01','2013-12-30','sku','0050100001',1100,0,0,'',5,100,0,0,0,0,'G','A',1,'กระป๋อง',100,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A10','2012-08-01','2013-12-30','sku','0050100002',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('A','A11','2012-08-01','2013-12-30','sku','0050100002',1100,0,0,'',5,100,0,0,0,0,'G','A',1,'กระป๋อง',100,0,0,'Fixed',now())");
    
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('M','M1','2012-08-01','2013-12-30','group','A',100,0,0,'',3,100,0,0,0,0,'S','0050100003',1,'กระป๋อง',100,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('M','M2','2012-08-01','2013-12-30','group','A',1100,0,0,'',5,100,0,0,0,0,'S','0050100003',1,'กระป๋อง',100,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('M','M3','2012-08-01','2013-12-30','group','B',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('M','M4','2012-08-01','2013-12-30','group','B',1100,0,0,'',5,100,0,0,0,0,'G','A',1,'กระป๋อง',100,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('B','B1','2012-08-01','2013-12-30','bill','',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('B','B2','2012-08-01','2013-12-30','bill','',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('B','B3','2012-08-01','2013-12-30','bill','',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('B','B4','2012-08-01','2013-12-30','bill','',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('B','B5','2012-08-01','2013-12-30','bill','',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('B','B6','2012-08-01','2013-12-30','bill','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-A1','2012-08-01','2013-12-30','accu-all','',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-A2','2012-08-01','2013-12-30','accu-all','',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-A3','2012-08-01','2013-12-30','accu-all','',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-A4','2012-08-01','2013-12-30','accu-all','',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-A5','2012-08-01','2013-12-30','accu-all','',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-A6','2012-08-01','2013-12-30','accu-all','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-A7','2012-08-01','2013-12-30','accu-all','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-B1','2012-08-01','2013-12-30','accu-l1','313',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-B2','2012-08-01','2013-12-30','accu-l1','313',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-B3','2012-08-01','2013-12-30','accu-l1','313',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-B4','2012-08-01','2013-12-30','accu-l1','313',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-B5','2012-08-01','2013-12-30','accu-l1','313',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-B6','2012-08-01','2013-12-30','accu-l1','313',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO oPromotion VALUES"
                   . "('AC','AC-B7','2012-08-01','2013-12-30','accu-l1','313',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
}

    $this->createTable('oFreeGrp', 
                       array(
                             'FreeGrpId' => 'string',
                             'ProductId' => 'string',
                             'FreePack' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (FreeGrpId, ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_oFreeGrp_oProduct','oFreeGrp','ProductId','oProduct','ProductId','RESTRICT','CASCADE');

if ($TESTING) {    
    $this->execute("INSERT INTO oFreeGrp VALUES('A','0050100001','กระป๋อง',now())");
    $this->execute("INSERT INTO oFreeGrp VALUES('A','0050100002','กระป๋อง',now())");
    $this->execute("INSERT INTO oFreeGrp VALUES('A','0050100003','กระป๋อง',now())");
    $this->execute("INSERT INTO oFreeGrp VALUES('A','0050100004','กระป๋อง',now())");
    $this->execute("INSERT INTO oFreeGrp VALUES('A','0050100005','กระป๋อง',now())");
}

    $this->createTable('oProductGrp', 
                       array(
                             'ProductGrpId' => 'string not null',
                             'ProductId' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ProductGrpId, ProductId)',
                             ), 'ENGINE=InnoDB');	
   $this->addForeignKey('fk_oProductGrp_oProduct','oProductGrp','ProductId','oProduct','ProductId','RESTRICT','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO oProductGrp VALUES('A','0050100001',now())");
    $this->execute("INSERT INTO oProductGrp VALUES('A','0050100002',now())");
    $this->execute("INSERT INTO oProductGrp VALUES('A','0050100003',now())");
    $this->execute("INSERT INTO oProductGrp VALUES('A','0050100004',now())");
    $this->execute("INSERT INTO oProductGrp VALUES('A','0050100005',now())");
    
    $this->execute("INSERT INTO oProductGrp VALUES('B','0010100001',now())");
    $this->execute("INSERT INTO oProductGrp VALUES('B','0010200001',now())");
    $this->execute("INSERT INTO oProductGrp VALUES('B','0010300001',now())");
    $this->execute("INSERT INTO oProductGrp VALUES('B','0010400001',now())");
}

    $this->createTable('cTargetSale', 
                       array(
                             'id' => 'pk',
                             'SaleId' => 'string',
                             'Level' => 'string',
                             'ProductOrGrpId' => 'string',
                             'TargetAmount' => 'integer',
                             'TargetQty' => 'integer',
                             'TargetPack' => 'string not null',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_cTargetSale_bSaleUnit','cTargetSale','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');

    $this->execute("INSERT INTO cTargetSale VALUES(1,'N001','all','',20000,0,'',now())");
    $this->execute("INSERT INTO cTargetSale VALUES(2,'N001','l1','313',10000,0,'',now())");
    $this->execute("INSERT INTO cTargetSale VALUES(3,'N001','l2','167',10000,0,'',now())");
    $this->execute("INSERT INTO cTargetSale VALUES(4,'N001','sku','0050100001',5000,0,'',now())");
    $this->execute("INSERT INTO cTargetSale VALUES(5,'N001','sku','0050100002',0,10,'หีบ',now())");
    
    $this->createTable('sCustomer', 
                       array(
                             'CustomerId' => 'string',
                             'SaleId' => 'string',
                             'Title' => 'string',
                             'CustomerName' => 'string',
                             'Type' => 'string',
                             'Trip1' => 'string',
                             'Trip2' => 'string',
                             'Trip3' => 'string',
                             'Province' => 'string',
                             'District' => 'string',
                             'SubDistrict' => 'string',
                             'ZipCode' => 'string',
                             'AddrNo' => 'string',
                             'Moo' => 'string',
                             'Village' => 'string',
                             'Soi' => 'string',
                             'Road' => 'string',
                             'Phone' => 'string',
                             'ContactPerson' => 'string',
                             'CreditTerm' => 'integer',
                             'CreditLimit' => 'decimal(20,2)',
                             'OverCreditType' => 'string',
                             'Due' => 'decimal(20,2)',
                             'PoseCheck' => 'decimal(20,2)',
                             'ReturnCheck' => 'decimal(20,2)',
                             'NewFlag' => 'char',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (CustomerId)',
                             ), 'ENGINE=InnoDB');
    $this->addForeignKey('fk_sCustomer_bSaleUnit','sCustomer','SaleId','bSaleUnit','SaleId','SET NULL','CASCADE');
    $this->addForeignKey('fk_sCustomer_oTrip1','sCustomer','Trip1','oTrip','TripName','RESTRICT','CASCADE');
    $this->addForeignKey('fk_sCustomer_oTrip2','sCustomer','Trip2','oTrip','TripName','RESTRICT','CASCADE');
    $this->addForeignKey('fk_sCustomer_oTrip3','sCustomer','Trip3','oTrip','TripName','RESTRICT','CASCADE');

  }		

  public function safeDown()
  {

  }

  private function reset()
  {
    $this->execute("SET foreign_key_checks = 0");
    $tables = $this->getDbConnection()->getSchema()->getTableNames();
    foreach ($tables as $table) {
        if (strcmp($table, 'tbl_migration') != 0)
            $this->dropTable($table);
    }
  }
}
