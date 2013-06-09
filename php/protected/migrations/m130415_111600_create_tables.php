<?php

class m130415_111600_create_tables extends CDbMigration
{
  public function safeUp()
  {

    $this->reset();
    
    $TESTING = true;
    
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
    $this->addForeignKey("fk_User_Employee", "User", "employee", "Employee", "EmployeeId", "SET NULL", "CASCADE");

    $hash = new myMD5();
    $pass = $hash->hash("1234");
    $this->execute("INSERT INTO User VALUES(1,'admin','$pass','System Administrator','admin',null)");

    $this->createTable('AuthItem', 
                       array(
                             'name' => 'string',
                             'type' => 'integer not null',
                             'description' => 'text',
                             'bizrule' => 'text',
                             'data' => 'text',
                             'PRIMARY KEY (name)',
                             ), 'ENGINE=InnoDB');
    $this->execute("INSERT INTO AuthItem VALUES('admin',2,'System Administrator',null,'N;')");
    $this->execute("INSERT INTO AuthItem VALUES('manager',2,'System Manager',null,'N;')");
    $this->execute("INSERT INTO AuthItem VALUES('staff',2,'Adminstrative Staff',null,'N;')");
    $this->execute("INSERT INTO AuthItem VALUES('supervisor',2,'Supervisor',null,'N;')");
    $this->execute("INSERT INTO AuthItem VALUES('employee',2,'Employee',null,'N;')");
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
    $this->execute("INSERT INTO AuthItemChild VALUES('manager','staff')");
    $this->execute("INSERT INTO AuthItemChild VALUES('staff','supervisor')");
    $this->execute("INSERT INTO AuthItemChild VALUES('supervisor','employee')");
    $this->execute("INSERT INTO AuthItemChild VALUES('employee','updateSelf')");

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
    $this->execute("INSERT INTO User VALUES(3,'staff','$pass','Test Administrative Staff','user',null)");
    $this->execute("INSERT INTO User VALUES(4,'supervisor','$pass','Test Supervisor','user',null)");
    $this->execute("INSERT INTO User VALUES(5,'employee','$pass','Test employee','user',null)");
    $this->execute("INSERT INTO AuthAssignment VALUES('manager','2',null,'N;')");
    $this->execute("INSERT INTO AuthAssignment VALUES('staff','3',null,'N;')");
    $this->execute("INSERT INTO AuthAssignment VALUES('supervisor','4',null,'N;')");
    $this->execute("INSERT INTO AuthAssignment VALUES('employee','5',null,'N;')");
}

    // backend only table
    $this->createTable('Config', // backend config information
                       array(
                             'DayToClear' => 'integer not null',
                             'SaleDiffPercent' => 'integer',
                             'StockDiffPercent' => 'integer',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');
    $this->execute("INSERT INTO Config VALUES(60,0,0,now())");

    // backend only table
    $this->createTable('Employee', // employee information
                       array(
                             'EmployeeId' => 'string',
                             'FirstName' => 'string not null',
                             'LastName' => 'string not null',
                             'Status' => 'string',
                             'primary key (EmployeeId)',
                             ), 'ENGINE=InnoDB');	

    // backend only table
    $this->createTable('SaleArea', // sale area information
                       array(
                             'AreaId' => 'string',
                             'AreaName' => 'string not null',
                             'Province' => 'string',
                             'District' => 'string',
                             'SubDistrict' => 'string',
                             'SupervisorId' => 'string',
                             'primary key (AreaId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_SaleArea_Employee','SaleArea','SupervisorId','Employee','EmployeeId','SET NULL','CASCADE');


    // backend only table
    $this->createTable('SaleUnit', // sale unit information
                       array(
                             'SaleId' => 'string',
                             'SaleName' => 'string not null',
                             'SaleType' => 'string',
                             'EmployeeId' => 'string',
                             'AreaId' => 'string',
                             'Active' => 'string',
                             'primary key (SaleId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_SaleUnit_Employee','SaleUnit','EmployeeId','Employee','EmployeeId','SET NULL','CASCADE');
    $this->addForeignKey('fk_SaleUnit_SaleArea','SaleUnit','AreaId','SaleArea','AreaId','SET NULL','CASCADE');

    // synch table
    $this->createTable('Device', // device information
                       array(
                             'DeviceId' => 'string',
                             'DeviceKey' => 'string',
                             'SaleId' => 'string',
                             'Username' => 'string',
                             'Password' => 'string',
                             'UpdateAt' => 'datetime',          
                             'primary key (DeviceId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_Device_SaleUnit','Device','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');

if ($TESTING) {
    $k = 0;    
    for ($i = 1; $i <= 5; $i++) {
        $area = $i+5;
        $supervisor = sprintf("S%03d", $i);
        $this->execute("INSERT INTO User VALUES($area,'sup$i','$pass','Supervisor $i','user','$supervisor')");
        $this->execute("INSERT INTO AuthAssignment VALUES('user',$area,null,'N;')");
        $this->execute("INSERT INTO Employee VALUES('$supervisor','นายซุป $i','นามสกุลซุป $i','ทำงาน')");
        $this->execute("INSERT INTO SaleArea VALUES('N$i','พื้นที่เหนือ $i','','','','$supervisor')");
        for ($j = 1; $j <= 5; $j++) {
            $k++;
            $sale = sprintf("N%03d", $k);
            $device = sprintf("D%03d", $k);
            $employee = sprintf("E%03d", $k);
            $name = array('ก','ข','ค','ม','ง','จ','ฉ','ช','ซ','ฌ','ญ','ฎ','ฏ','ฐ','ฑ','ฒ','ณ','ด','ต','ถ','ท','ธ','บ','ป','ผ','ฝ');
            $this->execute("INSERT INTO Employee VALUES('$employee','นายสมมติ $name[$k]','นามสกุลสมมติ $k','ทำงาน')");
            $this->execute("INSERT INTO Device VALUES('$device','','$sale','$device','$pass',now())");
            $this->execute("INSERT INTO SaleUnit VALUES('$sale','หน่วยขายเหนือ $k','เครดิต','$employee','N$i','Y')");
        }
    }
}

    // synch table
    $this->createTable('DeviceSetting', // device setting
                       array(
                             'SaleId' => 'string',
                             'SaleType' => 'string',
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
    $this->addForeignKey('fk_DeviceSetting_SaleUnit','DeviceSetting','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO DeviceSetting VALUES('N001','เครดิต','A','M','B','AC','sku','Y',60,now())");
}
    
    // synch table
    $this->createTable('ControlRunning', // control running option - mutable
                       array(
                             'ControlId' => 'string',
                             'ControlName' => 'string not null',
                             'Prefix' => 'string not null',         
                             'primary key (ControlId)',
                             ), 'ENGINE=InnoDB');   

if ($TESTING) {
    $this->execute("INSERT INTO ControlRunning VALUES('C01','Sale Order','SO')");
    $this->execute("INSERT INTO ControlRunning VALUES('C02','Invoice','IN')");
    $this->execute("INSERT INTO ControlRunning VALUES('C03','รับคืนสินค้า','RE')");
    $this->execute("INSERT INTO ControlRunning VALUES('C04','เปลี่ยนสินค้า','EX')");
    $this->execute("INSERT INTO ControlRunning VALUES('C05','ใบเบิกสินค้า','RQ')");
    $this->execute("INSERT INTO ControlRunning VALUES('C06','ใบส่งสินค้า','SN')");
    $this->execute("INSERT INTO ControlRunning VALUES('C07','ใบรับสินค้า','RC')");
    $this->execute("INSERT INTO ControlRunning VALUES('C08','รหัสร้านค้า','CU')");
}

    // fixed option tables
    $this->createTable('ControlNo', // control number for each device 
                       array(
                             'SaleId' => 'string',
                             'ControlId' => 'string',
                             'Year' => 'integer',
                             'Month' => 'integer',
                             'No' => 'integer',
                             'UpdateAt' => 'datetime',			
                             'primary key (SaleId, ControlId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_ControlNo_SaleUnit','ControlNo','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');
    $this->addForeignKey('fk_ControlNo_ControlRunning','ControlNo','ControlId','ControlRunning','ControlId','RESTRICT','CASCADE');

if ($TESTING) {
    $year = date("y");
    $month = date("m");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C01',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C02',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C03',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C04',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C05',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C06',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C07',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C08',$year,$month,1,now())");
}

    // fixed option tables
    $this->createTable('Trip', // trip option - fixed
                       array(
                             'TripId' => 'pk',
                             'TripName' => 'string not null',
                             ), 'ENGINE=InnoDB');	
    
    $this->execute("INSERT INTO Trip VALUES(1,'วันจันทร์')");
    $this->execute("INSERT INTO Trip VALUES(2,'วันอังคาร')");
    $this->execute("INSERT INTO Trip VALUES(3,'วันพุธ')");
    $this->execute("INSERT INTO Trip VALUES(4,'วันพฤหัส')");
    $this->execute("INSERT INTO Trip VALUES(5,'วันศุกร์')");
    $this->execute("INSERT INTO Trip VALUES(6,'วันเสาร์')");
    $this->execute("INSERT INTO Trip VALUES(7,'วันอาทิตย์')");
    for ($i = 1; $i <= 31; $i++)
      $this->execute("INSERT INTO Trip(TripName) VALUES('วันที่ $i')");

    $this->createTable('SaleHistory', // generate sale history sent to device
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
    $this->addForeignKey('fk_SaleHistory_SaleUnit','SaleHistory','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');

    // fixed option tables
    $this->createTable('Location', 
                       array(
                             'LocationId' => 'string',
                             'Province' => 'string',
                             'District' => 'string',
                             'SubDistrict' => 'string',
                             'ZipCode' => 'string',
                             'primary key (LocationId)',
                             ), 'ENGINE=InnoDB');   

    if (FALSE && ($handle = fopen(dirname(__FILE__).'/Location.csv', "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $this->execute("INSERT INTO Location VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]')");
        }
        fclose($handle);
    }
        
    // sync option tables
    $this->createTable('CustomerTitle', 
                       array(
                             'CustomerTitle' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'primary key (CustomerTitle)',
                             ), 'ENGINE=InnoDB');	
    $this->execute("INSERT INTO CustomerTitle VALUES('บม.จ.',now())");
    $this->execute("INSERT INTO CustomerTitle VALUES('ร้าน',now())");
    
    $this->createTable('StockCheckList', 
                       array(
                             'SaleId' => 'string',
                             'GrpLevel1Id' => 'string',
                             'GrpLevel2Id' => 'string',
                             'GrpLevel3Id' => 'string',
                             'ProductId' => 'string',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_StockCheckList_SaleUnit','StockCheckList','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');
    $this->addForeignKey('fk_StockCheckList_GrpLevel1','StockCheckList','GrpLevel1Id','GrpLevel1','GrpLevel1Id','CASCADE','CASCADE');
    $this->addForeignKey('fk_StockCheckList_GrpLevel2','StockCheckList','GrpLevel2Id','GrpLevel2','GrpLevel2Id','CASCADE','CASCADE');
    $this->addForeignKey('fk_StockCheckList_GrpLevel3','StockCheckList','GrpLevel3Id','GrpLevel3','GrpLevel3Id','CASCADE','CASCADE');
    $this->addForeignKey('fk_StockCheckList_Product','StockCheckList','ProductId','Product','ProductId','CASCADE','CASCADE');

    $this->execute("INSERT INTO StockCheckList VALUES('N001','309','144',null,'',now())");
    $this->execute("INSERT INTO StockCheckList VALUES('N001','313','167',null,'0050100001',now())");
    
    $this->createTable('StockCheck', 
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
                             'BuyQtyLevel1' => 'integer',
                             'BuyQtyLevel2' => 'integer',
                             'BuyQtyLevel3' => 'integer',
                             'BuyQtyLevel4' => 'integer',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (CheckDate, CustomerId, ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_StockCheck_SaleUnit','StockCheck','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
    $this->addForeignKey('fk_StockCheck_Customer','StockCheck','CustomerId','Customer','CustomerId','CASCADE','CASCADE');
    $this->addForeignKey('fk_StockCheck_Product','StockCheck','ProductId','Product','ProductId','CASCADE','CASCADE');
   
    // sync option tables
    $this->createTable('GrpLevel1', 
                       array(
                             'GrpLevel1Id' => 'string',
                             'GrpLevel1Name' => 'string not null UNIQUE',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (GrpLevel1Id)',
                             ), 'ENGINE=InnoDB');   
if ($TESTING) {
    $this->execute("INSERT INTO GrpLevel1 VALUES('306','GUNDAM',now())");
    $this->execute("INSERT INTO GrpLevel1 VALUES('309','COOK',now())");
    $this->execute("INSERT INTO GrpLevel1 VALUES('312','NECTRA',now())");
    $this->execute("INSERT INTO GrpLevel1 VALUES('313','SEALECT',now())");
}

    // sync option tables
    $this->createTable('GrpLevel2', 
                       array(
                             'GrpLevel1Id' => 'string not null',
                             'GrpLevel2Id' => 'string',
                             'GrpLevel2Name' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (GrpLevel2Id)',
                             ), 'ENGINE=InnoDB');   
    
    $this->execute("INSERT INTO GrpLevel2 VALUES('306','190','ข้าวโพดอบกรอบฮิโรชิกันดั้ม',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('309','144','น้ำมันพืชกุ๊กขวด',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('309','145','น้ำมันพืชกุ๊กปี๊ป',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('312','186','ผลิตภัณฑ์ตราเน็กตร้า',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('313','167','ทูน่า-ซีเล็ก',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('313','168','ซีเล็กในซอสมะเขือเทศ',now())");
    
    // sync option tables
    $this->createTable('GrpLevel3', 
                       array(
                             'GrpLevel2Id' => 'string not null',
                             'GrpLevel3Id' => 'string',
                             'GrpLevel3Name' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (GrpLevel3Id)',
                             ), 'ENGINE=InnoDB');   

    // sync option tables
    $this->createTable('Product', 
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
                             'WeightLevel1' => 'integer',
                             'WeightLevel2' => 'integer',
                             'WeightLevel3' => 'integer',
                             'WeightLevel4' => 'integer',
                             'FreeFlag' => 'char',
                             'VatFlag' => 'char',
                             'ShipFlag' => 'char',
                             'MinShip' => 'decimal(10,2)',
                             'ShipFee' => 'decimal(10,2)',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_Product_GrpLevel1','Product','GrpLevel1Id','GrpLevel1','GrpLevel1Id','RESTRICT','CASCADE');
    $this->addForeignKey('fk_Product_GrpLevel2','Product','GrpLevel2Id','GrpLevel2','GrpLevel2Id','SET NULL','CASCADE');
    $this->addForeignKey('fk_Product_GrpLevel3','Product','GrpLevel3Id','GrpLevel3','GrpLevel3Id','SET NULL','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144',null,'0010100001','น้ำมันกุ๊กถั่วเหลือง 1/4 ลิตร','หีบ','','','',614.37,0,0,0,0,0,0,0,'N','Y','N',5000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144',null,'0010200001','น้ำมันกุ๊กถั่วเหลือง 1/2 ลิตร','หีบ','','','',555.77,0,0,0,0,0,0,0,'N','Y','N',5000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144',null,'0010300001','น้ำมันกุ๊กทานตะวัน 1/2 ลิตร','หีบ','','','',913.89,0,0,0,0,0,0,0,'N','Y','N',5000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144',null,'0010400001','น้ำมันกุ๊กถั่วเหลือง 1 ลิตร','หีบ','','','',525.39,0,0,0,0,0,0,0,'N','Y','N',5000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167',null,'0050100001','ซีเล็กแซนวิชน้ำมัน 185 กรัม','หีบ','','','กระป๋อง',1284,0,0,0,0,0,0,0,'N','Y','N',5000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167',null,'0050100002','ซีเล็กแซนวิชน้ำเกลือ 185 กรัม','หีบ','','','กระป๋อง',1284,0,0,0,0,0,0,0,'N','Y','N',5000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167',null,'0050100003','ซีเล็กแซนวิชน้ำมัน 185 กรัม แพ็ค 4','หีบ','กล่อง','','กระป๋อง',1284,200,0,0,0,0,0,0,'N','Y','N',5000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167',null,'0050100004','ซีเล็กแซนวิชน้ำเปล่า 185 กรัม','หีบ','กล่อง','โหล','กระป๋อง',1284,200,50,0,0,0,0,0,'N','Y','N',5000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167',null,'0050100005','ซีเล็กแซนวิชน้ำแร่ 185 กรัม','หีบ','กล่อง','โหล','กระป๋อง',1284,200,50,5,0,0,0,0,'N','Y','N',5000,100,now())");
}

    $this->createTable('Stock', 
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
    $this->addForeignKey('fk_Stock_SaleUnit','Stock','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');
    $this->addForeignKey('fk_Stock_Product','Stock','ProductId','Product','ProductId','RESTRICT','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO Stock VALUES('N001','0010100001',10,20,20,20,now())");
    $this->execute("INSERT INTO Stock VALUES('N001','0010200001',20,10,20,20,now())");
    $this->execute("INSERT INTO Stock VALUES('N001','0010300001',10,0,20,20,now())");
    $this->execute("INSERT INTO Stock VALUES('N001','0010400001',20,10,20,20,now())");
    $this->execute("INSERT INTO Stock VALUES('N001','0050100001',10,20,20,20,now())");
    $this->execute("INSERT INTO Stock VALUES('N001','0050100002',20,30,20,20,now())");
    $this->execute("INSERT INTO Stock VALUES('N001','0050100003',10,0,20,20,now())");
    $this->execute("INSERT INTO Stock VALUES('N001','0050100004',20,20,20,20,now())");
    $this->execute("INSERT INTO Stock VALUES('N001','0050100005',10,20,20,20,now())");

}

/*
    $this->createTable('fStockRequest', 
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
*/

    // sync option tables
    $this->createTable('PaymentType', 
                       array(
                             'PaymentType' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (PaymentType)',
                             ), 'ENGINE=InnoDB');   

    $this->createTable('BillCollection', 
                       array(
                             'CollectionNo' => 'string',
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'CollectionDate' => 'date',
                             'CollectionAmount' => 'decimal(20,2)',
                             'PaidAmount' => 'decimal(20,2)',
                             'CollectionStatus' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (CollectionNo)',
                             ), 'ENGINE=InnoDB');   

    $this->createTable('Payment', 
                       array(
                             'CollectionNo' => 'string',
                             'PaymentId' => 'string',
                             'PaymentType' => 'string',
                             'PaidAmount' => 'decimal(20,2)',
                             'PaymentDate' => 'date',
                             'DocNo' => 'string',
                             'DocNote' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (PaymentId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_Payment_BillCollection','Payment','CollectionNo','BillCollection','CollectionNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_Payment_PaymentType','Payment','PaymentType','PaymentType','PaymentType','RESTRICT','CASCADE');

    $this->createTable('fOrderPayment', 
                       array(
                             'PaymentId' => 'string',
                             'OrderNo' => 'string',
                             'Amount' => 'decimal(20,2)',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (PaymentId,OrderNo)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_fOrderPayment_fPayment','fOrderPayment','PaymentId','fPayment','PaymentId','CASCADE','CASCADE');
    $this->addForeignKey('fk_fOrderPayment_fProductOrder','fOrderPayment','OrderNo','fProductOrder','OrderNo','CASCADE','CASCADE');
  
    $this->createTable('ProductOrder', 
                       array(
                             'OrderNo' => 'string',
                             'OrderType' => 'string',
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'OrderDate' => 'date',
                             'Total' => 'decimal(20,2)',
                             'Vat' => 'decimal(20,2)',
                             'Discount' => 'decimal(20,2)',
                             'Shipping' => 'decimal(20,2)',
                             'DeliverDate' => 'date',
                             'DeliverAddress' => 'text',
                             'PaymentType' => 'string',
                             'Status' => 'string',
                             'Remark' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_ProductOrder_SaleUnit','ProductOrder','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
    $this->addForeignKey('fk_ProductOrder_Customer','ProductOrder','CustomerId','Customer','CustomerId','RESTRICT','CASCADE');

    $this->createTable('OrderDetail',
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
                             'OrderNoUsed' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_OrderDetail_ProductOrder','OrderDetail','OrderNo','ProductOrder','OrderNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_OrderDetail_Product','OrderDetail','ProductId','Product','ProductId','RESTRICT','CASCADE');
 
    $this->createTable('ProductInvoice', 
                       array(
                             'InvoiceNo' => 'string',
                             'OrderNo' => 'string',
                             'InvoiceDate' => 'date',
                             'DueDate' => 'date',
                             'Total' => 'decimal(20,2)',
                             'Paid' => 'decimal(20,2)',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (InvoiceNo)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_ProductInvoice_ProductOrder','ProductInvoice','OrderNo','ProductOrder','OrderNo','CASCADE','CASCADE');
 
    $this->createTable('InvoiceDetail',
                       array(
                             'InvoiceNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer',
                             'QtyLevel2' => 'integer',
                             'QtyLevel3' => 'integer',
                             'QtyLevel4' => 'integer',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (InvoiceNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_InvoiceDetail_ProductInvoice','InvoiceDetail','InvoiceNo','ProductInvoice','InvoiceNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_InvoiceDetail_Product','InvoiceDetail','ProductId','Product','ProductId','RESTRICT','CASCADE');
 
    $this->createTable('ProductReturn', 
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
    $this->addForeignKey('fk_ProductReturn_SaleUnit','ProductReturn','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
    $this->addForeignKey('fk_ProductReturn_Customer','ProductReturn','CustomerId','Customer','CustomerId','RESTRICT','CASCADE');

    $this->createTable('ReturnDetail', 
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
    $this->addForeignKey('fk_ReturnDetail_ProductReturn','ReturnDetail','ReturnNo','ProductReturn','ReturnNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_ReturnDetail_Product','ReturnDetail','ProductId','Product','ProductId','RESTRICT','CASCADE');

    $this->createTable('FreeDetail', 
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
    $this->addForeignKey('fk_FreeDetail_ProductOrder','FreeDetail','OrderNo','ProductOrder','OrderNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_FreeDetail_Promotion','FreeDetail','PromotionId','Promotion','PromotionId','RESTRICT','CASCADE');
    $this->addForeignKey('fk_FreeDetail_Product','FreeDetail','FreeProductId','Product','ProductId','RESTRICT','CASCADE');

    $this->createTable('DiscDetail', 
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
    $this->addForeignKey('fk_DiscDetail_ProductOrder','DiscDetail','OrderNo','ProductOrder','OrderNo','CASCADE','CASCADE');
    $this->addForeignKey('fk_DiscDetail_Promotion','DiscDetail','PromotionId','Promotion','PromotionId','RESTRICT','CASCADE');

    // sync option tables
    $this->createTable('Promotion', 
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
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A1','2012-08-01','2013-12-30','sku','0050100003',0,0,1,'หีบ',5,0,1,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A2','2012-08-01','2013-12-30','sku','0050100003',0,0,11,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A3','2012-08-01','2013-12-30','sku','0050100003',0,0,21,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A4','2012-08-01','2013-12-30','sku','0050100003',0,0,31,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A5','2012-08-01','2013-12-30','sku','0050100003',0,0,41,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A6','2012-08-01','2013-12-30','sku','0050100003',0,0,51,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'กระป๋อง',0,1,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A8','2012-08-01','2013-12-30','sku','0050100001',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A9','2012-08-01','2013-12-30','sku','0050100001',1100,0,0,'',5,100,0,0,0,0,'G','A',1,'กระป๋อง',100,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A10','2012-08-01','2013-12-30','sku','0050100002',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A11','2012-08-01','2013-12-30','sku','0050100002',1100,0,0,'',5,100,0,0,0,0,'G','A',1,'กระป๋อง',100,0,0,'Fixed',now())");
    
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M','M1','2012-08-01','2013-12-30','group','A',100,0,0,'',3,100,0,0,0,0,'S','0050100003',1,'กระป๋อง',100,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M','M2','2012-08-01','2013-12-30','group','A',1100,0,0,'',5,100,0,0,0,0,'S','0050100003',1,'กระป๋อง',100,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M','M3','2012-08-01','2013-12-30','group','B',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M','M4','2012-08-01','2013-12-30','group','B',1100,0,0,'',5,100,0,0,0,0,'G','A',1,'กระป๋อง',100,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B1','2012-08-01','2013-12-30','bill','',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B2','2012-08-01','2013-12-30','bill','',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B3','2012-08-01','2013-12-30','bill','',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B4','2012-08-01','2013-12-30','bill','',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B5','2012-08-01','2013-12-30','bill','',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B6','2012-08-01','2013-12-30','bill','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A1','2012-08-01','2013-12-30','accu-all','',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A2','2012-08-01','2013-12-30','accu-all','',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A3','2012-08-01','2013-12-30','accu-all','',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A4','2012-08-01','2013-12-30','accu-all','',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A5','2012-08-01','2013-12-30','accu-all','',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A6','2012-08-01','2013-12-30','accu-all','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A7','2012-08-01','2013-12-30','accu-all','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B1','2012-08-01','2013-12-30','accu-l1','313',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B2','2012-08-01','2013-12-30','accu-l1','313',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B3','2012-08-01','2013-12-30','accu-l1','313',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B4','2012-08-01','2013-12-30','accu-l1','313',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B5','2012-08-01','2013-12-30','accu-l1','313',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B6','2012-08-01','2013-12-30','accu-l1','313',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B7','2012-08-01','2013-12-30','accu-l1','313',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'Fixed',now())");
}

    // sync option tables
    $this->createTable('FreeGrp', 
                       array(
                             'FreeGrpId' => 'string',
                             'ProductId' => 'string',
                             'FreePack' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (FreeGrpId, ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_FreeGrp_Product','FreeGrp','ProductId','Product','ProductId','RESTRICT','CASCADE');

if ($TESTING) {    
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100001','กระป๋อง',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100002','กระป๋อง',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100003','กระป๋อง',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100004','กระป๋อง',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100005','กระป๋อง',now())");
}

    // sync option tables
    $this->createTable('ProductGrp', 
                       array(
                             'ProductGrpId' => 'string not null',
                             'ProductId' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ProductGrpId, ProductId)',
                             ), 'ENGINE=InnoDB');	
   $this->addForeignKey('fk_ProductGrp_Product','ProductGrp','ProductId','Product','ProductId','RESTRICT','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO ProductGrp VALUES('A','0050100001',now())");
    $this->execute("INSERT INTO ProductGrp VALUES('A','0050100002',now())");
    $this->execute("INSERT INTO ProductGrp VALUES('A','0050100003',now())");
    $this->execute("INSERT INTO ProductGrp VALUES('A','0050100004',now())");
    $this->execute("INSERT INTO ProductGrp VALUES('A','0050100005',now())");
    
    $this->execute("INSERT INTO ProductGrp VALUES('B','0010100001',now())");
    $this->execute("INSERT INTO ProductGrp VALUES('B','0010200001',now())");
    $this->execute("INSERT INTO ProductGrp VALUES('B','0010300001',now())");
    $this->execute("INSERT INTO ProductGrp VALUES('B','0010400001',now())");
}

    $this->createTable('TargetSale', 
                       array(
                             'SaleId' => 'string',
                             'Level' => 'string',
                             'ProductOrGrpId' => 'string',
                             'TargetAmount' => 'integer',
                             'TargetQty' => 'integer',
                             'TargetPack' => 'string not null',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_TargetSale_SaleUnit','TargetSale','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');
if ($TESTING) {
    $this->execute("INSERT INTO TargetSale VALUES('N001','all','',20000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','l1','313',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','l2','167',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','sku','0050100001',5000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','sku','0050100002',0,10,'หีบ',now())");
}
    // Synch Table
    $this->createTable('Customer', 
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
                             'Promotion' => 'string',
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
    $this->addForeignKey('fk_Customer_SaleUnit','Customer','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
if ($TESTING) {
    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00113050001','N001','ร้าน','สุขใจ','CR','วันจันทร์','วันพุธ','',"
                . "'ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','33','5','สบายดี','4','พหลโยธิน',"
                . "'02-564-3333','คุณอ้อย','Manual',30,20000,'N',0,0,0,'N',now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00113050002','N001','ร้าน','มีดี','CR','วันจันทร์','วันศุกร์','',"
                . "'ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','11','2','ชมฟ้า','1','รังสิต-นครนายก',"
                . "'02-564-5555','คุณเอ','Manual',60,30000,'P',0,0,0,'N',now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00113050003','N001','ร้าน','ใจดี','CR','วันอังคาร','วันพุธ','',"
                . "'นนทบุรี','บางกรวย','บางกรวย','11130','33','5','สบายดี','4','ติวานนท์',"
                . "'02-564-6666','คุณส้ม','Manual',30,20000,'N',0,0,0,'N',now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00113050004','N001','ร้าน','รวยดี','CR','วันอังคาร','วันศุกร์','',"
                . "'นนทบุรี','บางกรวย','บางกรวย','11130','11','2','ชมฟ้า','1','ติวานนท์',"
                . "'02-564-7777','คุณรวย','Manual',60,30000,'P',0,0,0,'N',now());");

/*    $this->execute("INSERT INTO `ProductOrder` VALUES('SOD00113050001', 'CREDIT', 'N001', 'CUD00113050001', '2013-05-08', 6730.93, 506.63, 639.50, '2013-05-08', '', 'เครดิต', 'ยืนยัน', '', '2013-06-08 10:04:39');");
    $this->execute("INSERT INTO `ProductOrder` VALUES('SOD00113050002', 'CREDIT', 'N001', 'CUD00113050001', '2013-05-10', 4802.09, 361.45, 663.82, '2013-05-10', '', 'เครดิต', 'ยืนยัน', '', '2013-06-08 10:06:05');");

    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050001', 'A11', 60.00, 0, 0, 0, 60.00, '2013-06-08 10:04:11');");
    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050001', 'A9', 190.00, 0, 0, 0, 190.00, '2013-06-08 10:04:02');");
    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050001', 'B2', 0.00, 4, 0, 0, 289.50, '2013-06-08 10:04:33');");
    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050001', 'M4', 100.00, 0, 0, 0, 100.00, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050002', 'A1', 10.00, 0, 0, 0, 10.00, '2013-06-08 10:04:58');");
    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050002', 'AC-B2', 0.00, 3, 0, 0, 275.64, '2013-06-08 10:05:55');");
    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050002', 'B2', 0.00, 5, 0, 0, 258.18, '2013-06-08 10:05:42');");
    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050002', 'M2', 70.00, 0, 0, 0, 70.00, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `DiscDetail` VALUES('SOD00113050002', 'M4', 50.00, 0, 0, 0, 50.00, '2013-06-08 10:05:35');");

    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'A11', '0050100001', 'กระป๋อง', 0.00, 12, '2013-06-08 10:04:11');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'A9', '0050100001', 'กระป๋อง', 0.00, 38, '2013-06-08 10:04:02');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100001', 'กระป๋อง', 0.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100002', 'กระป๋อง', 0.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100003', 'กระป๋อง', 0.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100004', 'กระป๋อง', 0.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100005', 'กระป๋อง', 5.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M2', '0050100003', 'กระป๋อง', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100001', 'กระป๋อง', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100002', 'กระป๋อง', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100003', 'กระป๋อง', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100004', 'กระป๋อง', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100005', 'กระป๋อง', 5.00, 2, '2013-06-08 10:05:35');");

    $this->execute("INSERT INTO `OrderDetail` VALUES('SOD00113050001', '0010400001', 4, 0, 0, 0, 525.39, 0.00, 0.00, 0.00, 'AC-B2', 'accu-l1', 'SOD00113050002', '2013-06-08 10:05:55');");
    $this->execute("INSERT INTO `OrderDetail` VALUES('SOD00113050001', '0050100001', 3, 0, 0, 0, 1284.00, 0.00, 0.00, 0.00, 'AC-B2', 'accu-l1', 'SOD00113050002', '2013-06-08 10:05:55');");
    $this->execute("INSERT INTO `OrderDetail` VALUES('SOD00113050001', '0050100002', 1, 0, 0, 0, 1284.00, 0.00, 0.00, 0.00, '', 'N', '', '2013-06-08 10:04:10');");
    $this->execute("INSERT INTO `OrderDetail` VALUES('SOD00113050002', '0010200001', 2, 0, 0, 0, 555.77, 0.00, 0.00, 0.00, 'AC-B2', 'accu-l1', 'SOD00113050002', '2013-06-08 10:05:55');");
    $this->execute("INSERT INTO `OrderDetail` VALUES('SOD00113050002', '0050100003', 2, 0, 0, 0, 1284.00, 200.00, 0.00, 0.00, '', 'N', '', '2013-06-08 10:04:58');");
    $this->execute("INSERT INTO `OrderDetail` VALUES('SOD00113050002', '0050100005', 1, 1, 0, 0, 1284.00, 200.00, 50.00, 5.00, '', 'N', '', '2013-06-08 10:05:03');");
*/

}
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
