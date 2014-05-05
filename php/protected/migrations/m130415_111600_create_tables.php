<?php

class m130415_111600_create_tables extends CDbMigration
{
  public function safeUp()
  {

    $this->reset();
    
    $TESTING = false;
    
    // System User Management Tables
    $this->createTable('User', 
                       array(
                             'id' => 'pk comment "Primary Key"',
                             'username' => 'string not null unique',
                             'password' => 'string not null',
                             'name' => 'string',
                             'role' => 'string',
                             'employee' => 'string'
                             ), 'ENGINE=InnoDB');
    //$this->addForeignKey("fk_User_AuthItem", "User", "role", "AuthItem", "name", "RESTRICT", "CASCADE");
    //$this->addForeignKey("fk_User_Employee", "User", "employee", "Employee", "EmployeeId", "SET NULL", "CASCADE");

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
    $this->execute("INSERT INTO AuthItem VALUES('user',2,'User',null,'N;')");
    $this->execute("INSERT INTO AuthItem VALUES('operator',1,'Operator','return Yii::app()->user->getState(\"userType\")==\"operator\";','N;')");
    $this->execute("INSERT INTO AuthItem VALUES('supervisor',1,'Supervisor','return Yii::app()->user->getState(\"userType\")==\"supervisor\";','N;')");
    $this->execute("INSERT INTO AuthItem VALUES('salesman',1,'Salesman','return Yii::app()->user->getState(\"userType\")==\"salesman\";','N;')");
    $this->execute("INSERT INTO AuthItem VALUES('updateSelf',1,'Update own information','return Yii::app()->user->getId()==".'$'."params[\"id\"];','N;')");

    $this->createTable('AuthItemChild', 
                       array(
                             'parent' => 'string not null',
                             'child' => 'string not null',
                             'PRIMARY KEY (parent, child)',
                             ), 'ENGINE=InnoDB');
    //$this->addForeignKey("fk_AuthItemChild_AuthItem1", "AuthItemChild", "parent", "AuthItem", "name", "CASCADE", "CASCADE");
    //$this->addForeignKey("fk_AuthItemChild_AuthItem2", "AuthItemChild", "child", "AuthItem", "name", "CASCADE", "CASCADE");

    $this->execute("INSERT INTO AuthItemChild VALUES('admin','manager')");
    $this->execute("INSERT INTO AuthItemChild VALUES('manager','user')");
    $this->execute("INSERT INTO AuthItemChild VALUES('user','operator')");
    $this->execute("INSERT INTO AuthItemChild VALUES('user','supervisor')");
    $this->execute("INSERT INTO AuthItemChild VALUES('user','salesman')");
    $this->execute("INSERT INTO AuthItemChild VALUES('user','updateSelf')");

    $this->createTable('AuthAssignment', 
                       array(
                             'itemname' => 'string not null',
                             'userid' => 'integer not null',
                             'bizrule' => 'text',
                             'data' => 'text',
                             ), 'ENGINE=InnoDB');
    //$this->addForeignKey("fk_AuthAssignment_AuthItem", "AuthAssignment", "itemname", "AuthItem", "name", "RESTRICT", "CASCADE");
    //$this->addForeignKey("fk_AuthAssignment_User", "AuthAssignment", "userid", "User", "id", "CASCADE", "CASCADE");

    $this->execute("INSERT INTO AuthAssignment VALUES('admin','1',null,'N;')");

if ($TESTING) {
    $this->execute("INSERT INTO User VALUES(2,'manager','$pass','Test System Manager','manager',null)");
    $this->execute("INSERT INTO User VALUES(3,'staff','$pass','Test Administrative Staff','user',null)");
    $this->execute("INSERT INTO User VALUES(4,'supervisor','$pass','Test Supervisor','user',null)");
    $this->execute("INSERT INTO User VALUES(5,'employee','$pass','Test employee','user',null)");
    $this->execute("INSERT INTO AuthAssignment VALUES('manager','2',null,'N;')");
    $this->execute("INSERT INTO AuthAssignment VALUES('user','3',null,'N;')");
    $this->execute("INSERT INTO AuthAssignment VALUES('user','4',null,'N;')");
    $this->execute("INSERT INTO AuthAssignment VALUES('user','5',null,'N;')");
}

    // backend only table
    $this->createTable('Config', // backend config information
                       array(
                             'id' => 'pk',
                             'DayToClear' => 'integer not null', // day to clear data
                             'Vat' => 'string not null', // vat calculation method - bill,sku
                             'OverStock' => 'char not null', // stock limit sale - Y, N
                             'ExchangeDiff' => 'integer not null', // product exchange diff value
                             'ExchangePaymentMethod' => 'string', // bill collection or cash
//                             'SaleDiffPercent' => 'integer DEFAULT 0',
//                             'StockDiffPercent' => 'integer DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');
    $this->execute("INSERT INTO Config VALUES(1,60,'bill','Y',50,'bill',now())");

    // backend only table
    $this->createTable('SyncLog', // backend config information
                       array(
                             'id' => 'pk',
                             'SaleId' => 'string not null',
                             'LogTime' => 'datetime',
                             'Action' => 'string',
                             'TableName' => 'string',
                             'NumRecords' => 'integer',
                             'Remark' => 'string',
                             ), 'ENGINE=InnoDB');

    // backend only table
    // check
    $this->createTable('Employee', // employee information
                       array(
                             'EmployeeId' => 'string not null',
                             'FirstName' => 'string not null',
                             'LastName' => 'string not null',
                             'Phone' => 'string not null',
//                             'Active' => 'char not null',
                             'primary key (EmployeeId)',
                             ), 'ENGINE=InnoDB');	

    // backend only table
    // check
    $this->createTable('SaleArea', // sale area information
                       array(
                             'AreaId' => 'string not null',
                             'AreaName' => 'string not null',
                             'SupervisorId' => 'string',
                             'primary key (AreaId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_SaleArea_Employee','SaleArea','SupervisorId','Employee','EmployeeId','SET NULL','CASCADE');


    // backend only table
    // check
    $this->createTable('SaleUnit', // sale unit information
                       array(
                             'SaleId' => 'string not null',
                             'SaleName' => 'string not null',
                             'SaleType' => 'string not null',
                             'EmployeeId' => 'string',
                             'AreaId' => 'string',
//                             'Active' => 'string not null',
                             'primary key (SaleId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_SaleUnit_Employee','SaleUnit','EmployeeId','Employee','EmployeeId','SET NULL','CASCADE');
    $this->addForeignKey('fk_SaleUnit_SaleArea','SaleUnit','AreaId','SaleArea','AreaId','SET NULL','CASCADE');

    // device-backend auth table
    // check
    $this->createTable('Device', // device information
                       array(
                             'DeviceId' => 'string not null',
                             'DeviceKey' => 'string',
                             'SaleId' => 'string not null',
                             'Username' => 'string not null',
                             'Password' => 'string',
                             'UpdateAt' => 'datetime',          
                             'primary key (SaleId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_Device_SaleUnit','Device','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');

if ($TESTING) {
    $k = 0;    
    for ($i = 1; $i <= 5; $i++) {
        $area = $i+5;
        $supervisor = sprintf("S%03d", $i);
        $this->execute("INSERT INTO User VALUES($area,'sup$i','$pass','Supervisor $i','user','$supervisor')");
        $this->execute("INSERT INTO AuthAssignment VALUES('user',$area,null,'N;')");
        $this->execute("INSERT INTO Employee VALUES('$supervisor','นายซุป $i','นามสกุลซุป $i','0812223344')");
        $this->execute("INSERT INTO SaleArea VALUES('N$i','พื้นที่เหนือ $i','$supervisor')");
        for ($j = 1; $j <= 5; $j++) {
            $k++;
            $sale = sprintf("N%03d", $k);
            $device = sprintf("D%03d", $k);
            $employee = sprintf("E%03d", $k);
            $name = array('','ก','ข','ค','ม','ง','จ','ฉ','ช','ซ','ฌ','ญ','ฎ','ฏ','ฐ','ฑ','ฒ','ณ','ด','ต','ถ','ท','ธ','บ','ป','ผ','ฝ');
            $this->execute("INSERT INTO Employee VALUES('$employee','นายสมมติ $name[$k]','นามสกุลสมมติ $k','0812223344')");
            $this->execute("INSERT INTO Device VALUES('$device','','$sale','$device','$pass',now())");
            if ($k==1)
                $this->execute("INSERT INTO SaleUnit VALUES('$sale','หน่วยขายเหนือ $k','เครดิต','$employee','N$i')");
            else
                $this->execute("INSERT INTO SaleUnit VALUES('$sale','หน่วยขายเหนือ $k','หน่วยรถ','$employee','N$i')");
        }
    }
}

    // upload table
    // to be added
    $this->createTable('DeviceSetting', // device setting
                       array(
                             'SaleId' => 'string not null',
                             'SaleType' => 'string not null',
                             'Vat' => 'string NOT NULL', // vat calculation method - bill,sku
                             'OverStock' => 'char NOT NULL', // stock limit sale - Y, N
                             'DayToClear' => 'integer NOT NULL', // day to clear data
                             'ExchangeDiff' => 'integer NOT NULL', // product exchange diff value
                             'ExchangePaymentMethod' => 'string NOT NULL', // bill collection or cash
                             'Capacity' => 'integer DEFAULT 0', //truck capacity
                             'UpdateAt' => 'datetime',			
                             'primary key (SaleId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_DeviceSetting_SaleUnit','DeviceSetting','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO DeviceSetting VALUES('N001','เครดิต','sku','Y',60,0,'',0,now())");
    $this->execute("INSERT INTO DeviceSetting VALUES('N002','หน่วยรถ','sku','Y',60,50,'bill',20000,now())");
    $this->execute("INSERT INTO DeviceSetting VALUES('N003','หน่วยรถ','sku','N',60,50,'cash',20000,now())");
    for ($k = 4; $k <= 25; $k++) {
        $sale = sprintf("N%03d", $k);
        $this->execute("INSERT INTO DeviceSetting VALUES('$sale','หน่วยรถ','sku','N',60,50,'cash',20000,now())");
    }
}

if (!$TESTING) {
        $this->execute("INSERT INTO Employee VALUES('S001','นายซุป','หัวหน้า','0812223344')");
        $this->execute("INSERT INTO SaleArea VALUES('N1','พื้นที่เหนือ 1','S001')");
        $this->execute("INSERT INTO Employee VALUES('E001','นายสัญญา','สายันต์','0812223344')");
        $this->execute("INSERT INTO Device VALUES('D001',null,'N001','D001','$pass',now())");
        $this->execute("INSERT INTO SaleUnit VALUES('N001','หน่วยขายเหนือ 1','หน่วยรถ','E001','N1')");
        $this->execute("INSERT INTO DeviceSetting VALUES('N001','หน่วยรถ','bill','Y',60,50,'bill',0,now())");
}
    
    // fixed option tables
    // check
    $this->createTable('ControlRunning', // control running option - mutable
                       array(
                             'ControlId' => 'string',
                             'ControlName' => 'string not null',
                             'Prefix' => 'string not null',         
                             'primary key (ControlId)',
                             ), 'ENGINE=InnoDB');   

    $this->execute("INSERT INTO ControlRunning VALUES('C01','Sale Order','SO')");
    $this->execute("INSERT INTO ControlRunning VALUES('C02','Invoice','IN')");
    $this->execute("INSERT INTO ControlRunning VALUES('C03','รับคืนสินค้า','RE')");
    $this->execute("INSERT INTO ControlRunning VALUES('C04','เปลี่ยนสินค้า','EX')");
    $this->execute("INSERT INTO ControlRunning VALUES('C05','ใบเบิกสินค้า','RQ')");
    $this->execute("INSERT INTO ControlRunning VALUES('C06','ใบส่งสินค้า','SN')");
    $this->execute("INSERT INTO ControlRunning VALUES('C07','ใบรับสินค้า','RC')");
    $this->execute("INSERT INTO ControlRunning VALUES('C08','รหัสร้านค้า','CU')");
    $this->execute("INSERT INTO ControlRunning VALUES('C09','Bill Collection','BC')");
    $this->execute("INSERT INTO ControlRunning VALUES('C10','Payment','PM')");
    $this->execute("INSERT INTO ControlRunning VALUES('C11','โอนสินค้า','TX')");
    $this->execute("INSERT INTO ControlRunning VALUES('C12','ใบเบิกสินค้า-backend','RQ')");
    $this->execute("INSERT INTO ControlRunning VALUES('C13','ใบส่งสินค้า-backend','SN')");
    $this->execute("INSERT INTO ControlRunning VALUES('C14','IR-backend','IR')");

    // synch table
    // check
    $this->createTable('ControlNo', // control number for each device 
                       array(
                             'SaleId' => 'string not null',
                             'ControlId' => 'string not null',
                             'Year' => 'integer not null',
                             'Month' => 'integer not null',
                             'No' => 'integer not null',
                             'UpdateAt' => 'datetime',			
                             'primary key (SaleId, ControlId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_ControlNo_SaleUnit','ControlNo','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_ControlNo_ControlRunning','ControlNo','ControlId','ControlRunning','ControlId','RESTRICT','CASCADE');


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
    $this->execute("INSERT INTO ControlNo VALUES('N001','C09',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C10',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C11',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C12',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C13',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N001','C14',$year,$month,1,now())");
if ($TESTING) {
    $this->execute("INSERT INTO ControlNo VALUES('N002','C01',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C02',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C03',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C04',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C05',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C06',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C07',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C08',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C09',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C10',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C11',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C12',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C13',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N002','C14',$year,$month,1,now())");

    $this->execute("INSERT INTO ControlNo VALUES('N003','C01',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C02',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C03',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C04',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C05',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C06',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C07',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C08',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C09',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C10',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C11',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C12',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C13',$year,$month,1,now())");
    $this->execute("INSERT INTO ControlNo VALUES('N003','C14',$year,$month,1,now())");
}

    // fixed option table
    // check
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

    // report upload
    // check
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
    //$this->addForeignKey('fk_SaleHistory_SaleUnit','SaleHistory','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');

    // fixed option table
    // check
if (false) {
    $this->createTable('Location', 
                       array(
                             'LocationId' => 'string',
                             'Province' => 'string',
                             'District' => 'string',
                             'SubDistrict' => 'string',
                             'ZipCode' => 'string',
                             'primary key (LocationId)',
                             ), 'ENGINE=InnoDB');   

    if (($handle = fopen(dirname(__FILE__).'/Location.csv', "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $this->execute("INSERT INTO Location VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]')");
        }
        fclose($handle);
    }
}       
    // upload options
    // check
    $this->createTable('CustomerTitle', 
                       array(
                             'CustomerTitle' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'primary key (CustomerTitle)',
                             ), 'ENGINE=InnoDB');	
    $this->execute("INSERT INTO CustomerTitle VALUES('บมจ.',now())");
    $this->execute("INSERT INTO CustomerTitle VALUES('ร้าน',now())");
 
    $this->createTable('StockStartList', 
                       array(
                             'SaleId' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer default 0',
                             'QtyLevel2' => 'integer default 0',
                             'QtyLevel3' => 'integer default 0',
                             'QtyLevel4' => 'integer default 0',
                             'UpdateAt' => 'datetime',
                             'primary key (SaleId, ProductId)',
                             ), 'ENGINE=InnoDB');   


    // sale upload options
    $this->createTable('StockCheckList', 
                       array(
                             'SaleId' => 'string not null',
                             'GrpLevel1Id' => 'string not null',
                             'GrpLevel2Id' => 'string not null',
                             'GrpLevel3Id' => 'string not null',
                             'ProductId' => 'string not null',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');	
    //$this->addForeignKey('fk_StockCheckList_SaleUnit','StockCheckList','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_StockCheckList_GrpLevel1','StockCheckList','GrpLevel1Id','GrpLevel1','GrpLevel1Id','CASCADE','CASCADE');
    //$this->addForeignKey('fk_StockCheckList_GrpLevel2','StockCheckList','GrpLevel2Id','GrpLevel2','GrpLevel2Id','CASCADE','CASCADE');
    //$this->addForeignKey('fk_StockCheckList_GrpLevel3','StockCheckList','GrpLevel3Id','GrpLevel3','GrpLevel3Id','CASCADE','CASCADE');
    //$this->addForeignKey('fk_StockCheckList_Product','StockCheckList','ProductId','Product','ProductId','CASCADE','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO StockCheckList VALUES('N001','309','144','','',now())");
    $this->execute("INSERT INTO StockCheckList VALUES('N001','313','167','','0050100001',now())");

    $this->execute("INSERT INTO StockCheckList VALUES('N002','309','144','','',now())");
    $this->execute("INSERT INTO StockCheckList VALUES('N002','313','167','','0050100001',now())");

    $this->execute("INSERT INTO StockCheckList VALUES('N003','309','144','','',now())");
    $this->execute("INSERT INTO StockCheckList VALUES('N003','313','167','','0050100001',now())");
}

    // transaction
    // check
    $this->createTable('StockCheck', 
                       array(
                             'SaleId' => 'string',                        
                             'Month' => 'int not null',
                             'Year' => 'int not null',
                             'CustomerId' => 'string',
                             'ProductId' => 'string',
                             'FrontQtyLevel1' => 'integer DEFAULT 0',
                             'FrontQtyLevel2' => 'integer DEFAULT 0',
                             'FrontQtyLevel3' => 'integer DEFAULT 0',
                             'FrontQtyLevel4' => 'integer DEFAULT 0',
                             'BackQtyLevel1' => 'integer DEFAULT 0',
                             'BackQtyLevel2' => 'integer DEFAULT 0',
                             'BackQtyLevel3' => 'integer DEFAULT 0',
                             'BackQtyLevel4' => 'integer DEFAULT 0',
                             'BuyQtyLevel1' => 'integer DEFAULT 0',
                             'BuyQtyLevel2' => 'integer DEFAULT 0',
                             'BuyQtyLevel3' => 'integer DEFAULT 0',
                             'BuyQtyLevel4' => 'integer DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (Month, Year, CustomerId, ProductId)',
                             ), 'ENGINE=InnoDB');	
    //$this->addForeignKey('fk_StockCheck_SaleUnit','StockCheck','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
    //$this->addForeignKey('fk_StockCheck_Customer','StockCheck','CustomerId','Customer','CustomerId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_StockCheck_Product','StockCheck','ProductId','Product','ProductId','CASCADE','CASCADE');
   
    // sync option tables
    $this->createTable('GrpLevel1', 
                       array(
                             'GrpLevel1Id' => 'string',
                             'GrpLevel1Name' => 'string not null UNIQUE',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (GrpLevel1Id)',
                             ), 'ENGINE=InnoDB');   
if ($TESTING||true) {
    $this->execute("INSERT INTO GrpLevel1 VALUES('306','GUNDAM',now())");
    $this->execute("INSERT INTO GrpLevel1 VALUES('309','COOK',now())");
    $this->execute("INSERT INTO GrpLevel1 VALUES('312','NECTRA',now())");
    $this->execute("INSERT INTO GrpLevel1 VALUES('313','SEALECT',now())");
    $this->execute("INSERT INTO GrpLevel1 VALUES('1','GLIGO',now())");
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
    
if ($TESTING||true) {
    $this->execute("INSERT INTO GrpLevel2 VALUES('306','190','ข้าวโพดอบกรอบฮิโรชิกันดั้ม',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('309','144','น้ำมันพืชกุ๊กชิ้น',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('309','145','น้ำมันพืชกุ๊กปี๊ป',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('312','186','ผลิตภัณฑ์ตราเน็กตร้า',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('313','167','ทูน่า-ซีเล็ก',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('313','168','ซีเล็กในซอสมะเขือเทศ',now())");
    $this->execute("INSERT INTO GrpLevel2 VALUES('1','1','กูลิโกะ',now())");
}
    // sync option tables
    $this->createTable('GrpLevel3', 
                       array(
                             'GrpLevel2Id' => 'string not null',
                             'GrpLevel3Id' => 'string',
                             'GrpLevel3Name' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (GrpLevel3Id)',
                             ), 'ENGINE=InnoDB');   

if ($TESTING||true) {
    $this->execute("INSERT INTO GrpLevel3 VALUES('1','1','กูลิโกะ',now())");
}

    // sync option tables
    $this->createTable('Product', 
                       array(
                             'GrpLevel1Id' => 'string NOT NULL DEFAULT ""',
                             'GrpLevel2Id' => 'string NOT NULL DEFAULT ""',
                             'GrpLevel3Id' => 'string NOT NULL DEFAULT ""',
                             'ProductId' => 'string not null',
                             'ProductName' => 'string not null',
                             'PackLevel1' => 'string',
                             'PackLevel2' => 'string',
                             'PackLevel3' => 'string',
                             'PackLevel4' => 'string',
                             'PriceLevel1' => 'decimal(10,2)',
                             'PriceLevel2' => 'decimal(10,2)',
                             'PriceLevel3' => 'decimal(10,2)',
                             'PriceLevel4' => 'decimal(10,2)',
                             'VolumeLevel1' => 'integer DEFAULT 0',
                             'VolumeLevel2' => 'integer DEFAULT 0',
                             'VolumeLevel3' => 'integer DEFAULT 0',
                             'VolumeLevel4' => 'integer DEFAULT 0',
                             'FreeFlag' => 'char',
                             'VatFlag' => 'char',
                             'ShipFlag' => 'char',
                             'MinShip' => 'decimal(10,2) DEFAULT 0',
                             'ShipFee' => 'decimal(10,2) DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ProductId)',
                             ), 'ENGINE=InnoDB');	
    //$this->addForeignKey('fk_Product_GrpLevel1','Product','GrpLevel1Id','GrpLevel1','GrpLevel1Id','RESTRICT','CASCADE');
    //$this->addForeignKey('fk_Product_GrpLevel2','Product','GrpLevel2Id','GrpLevel2','GrpLevel2Id','SET NULL','CASCADE');
    //$this->addForeignKey('fk_Product_GrpLevel3','Product','GrpLevel3Id','GrpLevel3','GrpLevel3Id','SET NULL','CASCADE');

if ($TESTING||true) {
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144','','0010100001','น้ำมันกุ๊กถั่วเหลือง 1/4 ลิตร','หีบ','','','ชิ้น',200,0,0,10,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144','','0010200001','น้ำมันกุ๊กถั่วเหลือง 1/2 ลิตร','หีบ','','','ชิ้น',200,0,0,20,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144','','0010300001','น้ำมันกุ๊กทานตะวัน 1/2 ลิตร','หีบ','','','ชิ้น',200,0,0,20,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144','','0010400001','น้ำมันกุ๊กถั่วเหลือง 1 ลิตร','หีบ','','','ชิ้น',200,0,0,30,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167','','0050100001','ซีเล็กแซนวิชน้ำมัน 185 กรัม','หีบ','','','ชิ้น',100,0,0,10,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167','','0050100002','ซีเล็กแซนวิชน้ำเกลือ 185 กรัม','หีบ','','','ชิ้น',100,0,0,10,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167','','0050100003','ซีเล็กแซนวิชน้ำมัน 185 กรัม แพ็ค 4','หีบ','','','ชิ้น',100,0,0,10,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167','','0050100004','ซีเล็กแซนวิชน้ำเปล่า 185 กรัม','หีบ','','','ชิ้น',100,0,0,10,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('313','167','','0050100005','ซีเล็กแซนวิชน้ำแร่ 185 กรัม','หีบ','','','ชิ้น',100,0,0,10,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000001','กูลิโกะ รสช็อคโกแลต','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000002','กูลิโกะ รสสตรอว์เบอร์รี','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000003','กูลิโกะ รสส้ม','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000004','กูลิโกะ รสองุ่น','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000005','กูลิโกะ รสมะนาว','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000006','กูลิโกะ รสหวาน','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('309','144','','0010500001','น้ำมันพืชกุ๊ก 1 ลิตร','หีบ','','','ชิ้น',200,0,0,20,100,0,0,10,'N','Y','N',2000,100,now())");
/*
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000011','กูลิโกะ รส1','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000012','กูลิโกะ รส2','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000013','กูลิโกะ รส3','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000014','กูลิโกะ รส4','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000015','กูลิโกะ รส5','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000016','กูลิโกะ รส6','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000017','กูลิโกะ รส7','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000018','กูลิโกะ รส8','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000019','กูลิโกะ รส9','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000020','กูลิโกะ รส10','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000021','กูลิโกะ รส11','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000022','กูลิโกะ รส12','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000023','กูลิโกะ รส13','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000024','กูลิโกะ รส14','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000025','กูลิโกะ รส15','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
    $this->execute("INSERT INTO Product VALUES"
                   . "('1','1','1','1000000026','กูลิโกะ รส16','หีบ','','','ชิ้น',100,0,0,2.5,100,0,0,10,'N','Y','N',2000,100,now())");
*/
}

    $this->createTable('Stock', 
                       array(
                             'SaleId' => 'string',
                             'ProductId' => 'string',
                             'StartQtyLevel1' => 'integer DEFAULT 0',
                             'StartQtyLevel2' => 'integer DEFAULT 0',
                             'StartQtyLevel3' => 'integer DEFAULT 0',
                             'StartQtyLevel4' => 'integer DEFAULT 0',
                             'CurrentQtyLevel1' => 'integer DEFAULT 0',
                             'CurrentQtyLevel2' => 'integer DEFAULT 0',
                             'CurrentQtyLevel3' => 'integer DEFAULT 0',
                             'CurrentQtyLevel4' => 'integer DEFAULT 0',
                             'BadQtyLevel1' => 'integer DEFAULT 0',
                             'BadQtyLevel2' => 'integer DEFAULT 0',
                             'BadQtyLevel3' => 'integer DEFAULT 0',
                             'BadQtyLevel4' => 'integer DEFAULT 0',
                             'MidInQtyLevel1' => 'integer DEFAULT 0',
                             'MidInQtyLevel2' => 'integer DEFAULT 0',
                             'MidInQtyLevel3' => 'integer DEFAULT 0',
                             'MidInQtyLevel4' => 'integer DEFAULT 0',
                             'ReturnQtyLevel1' => 'integer DEFAULT 0',
                             'ReturnQtyLevel2' => 'integer DEFAULT 0',
                             'ReturnQtyLevel3' => 'integer DEFAULT 0',
                             'ReturnQtyLevel4' => 'integer DEFAULT 0',
                             'ReplaceQtyLevel1' => 'integer DEFAULT 0',
                             'ReplaceQtyLevel2' => 'integer DEFAULT 0',
                             'ReplaceQtyLevel3' => 'integer DEFAULT 0',
                             'ReplaceQtyLevel4' => 'integer DEFAULT 0',
                             'SaleQtyLevel1' => 'integer DEFAULT 0',
                             'SaleQtyLevel2' => 'integer DEFAULT 0',
                             'SaleQtyLevel3' => 'integer DEFAULT 0',
                             'SaleQtyLevel4' => 'integer DEFAULT 0',
                             'FreeQtyLevel1' => 'integer DEFAULT 0',
                             'FreeQtyLevel2' => 'integer DEFAULT 0',
                             'FreeQtyLevel3' => 'integer DEFAULT 0',
                             'FreeQtyLevel4' => 'integer DEFAULT 0',
                             'MidOutQtyLevel1' => 'integer DEFAULT 0',
                             'MidOutQtyLevel2' => 'integer DEFAULT 0',
                             'MidOutQtyLevel3' => 'integer DEFAULT 0',
                             'MidOutQtyLevel4' => 'integer DEFAULT 0',
                             'EndQtyLevel1' => 'integer DEFAULT 0',
                             'EndQtyLevel2' => 'integer DEFAULT 0',
                             'EndQtyLevel3' => 'integer DEFAULT 0',
                             'EndQtyLevel4' => 'integer DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (SaleId, ProductId)',
                             ), 'ENGINE=InnoDB');	
    //$this->addForeignKey('fk_Stock_SaleUnit','Stock','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_Stock_Product','Stock','ProductId','Product','ProductId','RESTRICT','CASCADE');

if ($TESTING) {
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0010100001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0010200001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0010300001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0010400001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0050100001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0050100002',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0050100003',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0050100004',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0050100005',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','0010500001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000002',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000003',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000004',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000005',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000006',20,0,0,20,20,0,0,20,now())");
/*
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000011',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000012',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000013',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000014',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000015',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000016',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000017',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000018',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000019',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000020',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000021',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000022',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000023',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000024',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000025',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N002','1000000026',20,0,0,20,20,0,0,20,now())");
*/
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0010100001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0010200001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0010300001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0010400001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0050100001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0050100002',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0050100003',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0050100004',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0050100005',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','0010500001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','1000000001',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','1000000002',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','1000000003',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','1000000004',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','1000000005',20,0,0,20,20,0,0,20,now())");
    $this->execute("INSERT INTO Stock(SaleId,ProductId,StartQtyLevel1,StartQtyLevel2,StartQtyLevel3,StartQtyLevel4,CurrentQtyLevel1,CurrentQtyLevel2,CurrentQtyLevel3,CurrentQtyLevel4,UpdateAt) VALUES('N003','1000000006',20,0,0,20,20,0,0,20,now())");
}

    // upload options
    // check
    $this->createTable('Warehouse', 
                       array(
                             'WarehouseId' => 'string not null',
                             'WarehouseName' => 'string not null',
                             'WarehouseType' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (WarehouseId)',
                             ), 'ENGINE=InnoDB');   
if (true) {
    $this->execute("INSERT INTO Warehouse VALUES('W1','คลัง 1','คลังใหญ่',now())");
    $this->execute("INSERT INTO Warehouse VALUES('W2','คลัง 2','คลังใหญ่',now())");
    $this->execute("INSERT INTO Warehouse VALUES('W3','คลัง 3','คลังใหญ่',now())");
    $this->execute("INSERT INTO Warehouse VALUES('C1','หน่วยรถ 1','คลังรถ',now())");
    $this->execute("INSERT INTO Warehouse VALUES('C2','หน่วยรถ 2','คลังรถ',now())");
    $this->execute("INSERT INTO Warehouse VALUES('C3','หน่วยรถ 3','คลังรถ',now())");
}

    // transaction
    // check
    $this->createTable('StockRequest', 
                       array(
                             'RequestNo' => 'string NOT NULL',
                             'RequestType' => 'string DEFAULT "สร้างโดย Backend"',
                             'RequestFlag' => 'string DEFAULT "ต้นทริป"',
                             'SaleId' => 'string NOT NULL',
                             'WarehouseId' => 'string',
                             'WarehouseName' => 'string',
                             'WarehouseType' => 'string',
                             'RequestDate' => 'date',
                             'Total' => 'decimal(10,2) DEFAULT 0',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (RequestNo)',
                             ), 'ENGINE=InnoDB');   

    // transaction
    // check
    $this->createTable('RequestDetail', 
                       array(
                             'RequestNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'PriceLevel1' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel2' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel3' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel4' => 'decimal(10,2) DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (RequestNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_RequestDetail_StockRequest','RequestDetail','RequestNo','StockRequest','RequestNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_bSaleUnit','sStock','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_oProduct','sStock','ProductId','oProduct','ProductId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('StockIR', 
                       array(
                             'IRNo' => 'string',
                             'SaleId' => 'string',
                             'IRDate' => 'date',
                             'Total' => 'decimal(10,2) DEFAULT 0',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (IRNo)',
                             ), 'ENGINE=InnoDB');   

    // transaction
    // check
    $this->createTable('RequestIR', 
                       array(
                             'IRNo' => 'string',
                             'RequestNo' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (IRNo, RequestNo)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_RequestIR_StockIRt','RequestIR','IRNo','StockIR','IRNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_bSaleUnit','sStock','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_oProduct','sStock','ProductId','oProduct','ProductId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('IRDetail', 
                       array(
                             'IRNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'PriceLevel1' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel2' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel3' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel4' => 'decimal(10,2) DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (IRNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_IRDetail_StockIR','IRDetail','IRNo','StockIR','IRNo','CASCADE','CASCADE');

    // transaction
    // check
    $this->createTable('StockDeliver', 
                       array(
                             'RequestNo' => 'string',
                             'DeliverNo' => 'string',
                             'SaleId' => 'string',
                             'WarehouseId' => 'string',
                             'WarehouseName' => 'string',
                             'WarehouseType' => 'string',
                             'DeliverDate' => 'date',
                             'Total' => 'decimal(10,2) DEFAULT 0',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (DeliverNo)',
                             ), 'ENGINE=InnoDB');   

    // transaction
    // check
    $this->createTable('DeliverDetail', 
                       array(
                             'DeliverNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'PriceLevel1' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel2' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel3' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel4' => 'decimal(10,2) DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (DeliverNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_DeliverDetail_StockRequest','DeliverDetail','DeliverNo','StockDeliver','DeliverNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_bSaleUnit','sStock','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_oProduct','sStock','ProductId','oProduct','ProductId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('StockReceive', 
                       array(
                             'RequestNo' => 'string',
                             'DeliverNo' => 'string',
                             'ReceiveNo' => 'string',
                             'SaleId' => 'string',
                             'ReceiveDate' => 'date',
                             'Total' => 'decimal(10,2) DEFAULT 0',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ReceiveNo)',
                             ), 'ENGINE=InnoDB');   

    // transaction
    // check
    $this->createTable('ReceiveDetail', 
                       array(
                             'ReceiveNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'PriceLevel1' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel2' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel3' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel4' => 'decimal(10,2) DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ReceiveNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_ReceiveDetail_StockRequest','ReceiveDetail','ReceiveNo','StockReceive','ReceiveNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_bSaleUnit','sStock','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_oProduct','sStock','ProductId','oProduct','ProductId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('StockTransfer', 
                       array(
                             'TransferNo' => 'string',
                             'SaleId' => 'string',
                             'WarehouseId' => 'string',
                             'WarehouseName' => 'string',
                             'WarehouseType' => 'string',
                             'TransferDate' => 'date',
                             'Total' => 'decimal(10,2) DEFAULT 0',
                             'Status' => 'string',
                             'EndTripFlag' => 'char',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (TransferNo)',
                             ), 'ENGINE=InnoDB');   

    // transaction
    // check
    $this->createTable('TransferDetail', 
                       array(
                             'TransferNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'PriceLevel1' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel2' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel3' => 'decimal(10,2) DEFAULT 0',
                             'PriceLevel4' => 'decimal(10,2) DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (TransferNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_TransferDetail_StockRequest','TransferDetail','TransferNo','StockTransfer','TransferNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_bSaleUnit','sStock','SaleId','bSaleUnit','SaleId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_sStock_oProduct','sStock','ProductId','oProduct','ProductId','RESTRICT','CASCADE');


    // upload options
    // check
    $this->createTable('BankAccount', 
                       array(
                             'BankId' => 'pk',
                             'Bank' => 'string not null',
                             'Branch' => 'string not null',
                             'AccountNo' => 'string not null',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');   

if (true) {
    $this->execute("INSERT INTO BankAccount VALUES(1,'กรุงเทพ','รังสิต','111-111111-1',now())");
    $this->execute("INSERT INTO BankAccount VALUES(2,'ไทยพาณิชย์','รังสิต','222-222222-2',now())");
    $this->execute("INSERT INTO BankAccount VALUES(3,'กสิกร','รังสิต','333-333333-3',now())");
    $this->execute("INSERT INTO BankAccount VALUES(4,'ทหารไทย','รังสิต','444-444444-4',now())");
}

    // transaction
    // check
    $this->createTable('MoneyTransfer', 
                       array(
                             'SaleId' => 'string',
                             'TransferDate' => 'date',
                             'StartDate' => 'date',
                             'EndDate' => 'date',
                             'Amount' => 'decimal(20,2) DEFAULT 0',
                             'BankAccount' => 'string',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (SaleId,EndDate)',
                             ), 'ENGINE=InnoDB');   

    // upload options
    // check
    $this->createTable('PaymentType', 
                       array(
                             'PaymentType' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (PaymentType)',
                             ), 'ENGINE=InnoDB');   

    $this->execute("INSERT INTO PaymentType VALUES('เช็ค',now())");
    $this->execute("INSERT INTO PaymentType VALUES('เงินสด',now())");
    $this->execute("INSERT INTO PaymentType VALUES('โอนเงินสด',now())");
    $this->execute("INSERT INTO PaymentType VALUES('CN',now())");

    // transaction
    // check
    $this->createTable('BillCollection', 
                       array(
                             'CollectionNo' => 'string',
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'CollectionDate' => 'date',
                             'CollectionAmount' => 'decimal(20,2) DEFAULT 0',
                             'PaidAmount' => 'decimal(20,2) DEFAULT 0',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (CollectionNo)',
                             ), 'ENGINE=InnoDB');   
    //$this->addForeignKey('fk_BillCollection_SaleUnit','BillCollection','SaleId','SaleUnit','SaleId','RESTRICT','CASCADE');
    //$this->addForeignKey('fk_BillCollection_Customer','BillCollection','CustomerId','Customer','CustomerId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('Payment', 
                       array(
                             'CollectionNo' => 'string',
                             'PaymentId' => 'string',
                             'PaymentType' => 'string',
                             'PaidAmount' => 'decimal(20,2) DEFAULT 0',
                             'DocNo' => 'string',
                             'DocDate' => 'string',
                             'Bank' => 'string',
                             'Branch' => 'string',
                             'AccountNo' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (PaymentId)',
                             ), 'ENGINE=InnoDB');   
    //$this->addForeignKey('fk_Payment_BillCollection','Payment','CollectionNo','BillCollection','CollectionNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_Payment_PaymentType','Payment','PaymentType','PaymentType','PaymentType','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('InvoicePayment', 
                       array(
                             'PaymentId' => 'string',
                             'InvoiceNo' => 'string',
                             'Amount' => 'decimal(20,2) DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (PaymentId,InvoiceNo)',
                             ), 'ENGINE=InnoDB');   
    //$this->addForeignKey('fk_InvoicePayment_Payment','InvoicePayment','PaymentId','Payment','PaymentId','CASCADE','CASCADE');
    //$this->addForeignKey('fk_InvoicePayment_ProductInvoice','InvoicePayment','InvoiceNo','ProductInvoice','InvoiceNo','CASCADE','CASCADE');
  
    // transaction
    // check
    $this->createTable('ProductOrder', 
                       array(
                             'OrderNo' => 'string',
                             'OrderType' => 'string',
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'OrderDate' => 'date',
                             'Total' => 'decimal(20,2) DEFAULT 0',
                             'Vat' => 'decimal(20,2) DEFAULT 0',
                             'Discount' => 'decimal(20,2) DEFAULT 0',
                             'Shipping' => 'decimal(20,2) DEFAULT 0',
                             'DeliverDate' => 'date',
                             'DeliverAddress' => 'text',
                             'PaymentType' => 'string',
                             'Status' => 'string',
                             'Remark' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo)',
                             ), 'ENGINE=InnoDB');   
    //$this->addForeignKey('fk_ProductOrder_SaleUnit','ProductOrder','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
    //$this->addForeignKey('fk_ProductOrder_Customer','ProductOrder','CustomerId','Customer','CustomerId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('OrderDetail',
                       array(
                             'OrderNo' => 'string',
                             'ProductId' => 'string',
                             'BuyLevel1' => 'integer DEFAULT 0',
                             'BuyLevel2' => 'integer DEFAULT 0',
                             'BuyLevel3' => 'integer DEFAULT 0',
                             'BuyLevel4' => 'integer DEFAULT 0',
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
    //$this->addForeignKey('fk_OrderDetail_Product','OrderDetail','ProductId','Product','ProductId','RESTRICT','CASCADE');
 
    // transaction
    // check 
    $this->createTable('ProductInvoice', 
                       array(
                             'InvoiceNo' => 'string',
                             'OrderNo' => 'string',
                             'SaleId' => 'string',
                             'InvoiceDate' => 'date',
                             'DueDate' => 'date',
                             'Total' => 'decimal(20,2) DEFAULT 0',
                             'Paid' => 'decimal(20,2) DEFAULT 0',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (InvoiceNo)',
                             ), 'ENGINE=InnoDB');   
    //$this->addForeignKey('fk_ProductInvoice_ProductOrder','ProductInvoice','OrderNo','ProductOrder','OrderNo','CASCADE','CASCADE');
 
    // transaction
    // check
    $this->createTable('InvoiceDetail',
                       array(
                             'InvoiceNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (InvoiceNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_InvoiceDetail_ProductInvoice','InvoiceDetail','InvoiceNo','ProductInvoice','InvoiceNo','CASCADE','CASCADE');
   //$this->addForeignKey('fk_InvoiceDetail_Product','InvoiceDetail','ProductId','Product','ProductId','RESTRICT','CASCADE');
 
    // transaction
    // check
    $this->createTable('ProductReturn', 
                       array(
                             'ReturnNo' => 'string',
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'ReturnDate' => 'date',
                             'Total' => 'decimal(20,2) DEFAULT 0',
                             'Vat' => 'decimal(20,2) DEFAULT 0',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ReturnNo)',
                             ), 'ENGINE=InnoDB');	
    //$this->addForeignKey('fk_ProductReturn_SaleUnit','ProductReturn','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
    //$this->addForeignKey('fk_ProductReturn_Customer','ProductReturn','CustomerId','Customer','CustomerId','RESTRICT','CASCADE');

    // transaction
    // check
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
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'PriceLevel1' => 'decimal(10,2)',
                             'PriceLevel2' => 'decimal(10,2)',
                             'PriceLevel3' => 'decimal(10,2)',
                             'PriceLevel4' => 'decimal(10,2)',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ReturnNo, ProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_ReturnDetail_ProductReturn','ReturnDetail','ReturnNo','ProductReturn','ReturnNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_ReturnDetail_Product','ReturnDetail','ProductId','Product','ProductId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('FreeDetail', 
                       array(
                             'OrderNo' => 'string',
                             'PromotionId' => 'string',
                             'FreeProductId' => 'string',
                             'FreePack' => 'string',
                             'FreePrice' => 'decimal(10,2)',
                             'FreeQty' => 'integer DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo, PromotionId, FreeProductId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_FreeDetail_ProductOrder','FreeDetail','OrderNo','ProductOrder','OrderNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_FreeDetail_Promotion','FreeDetail','PromotionId','Promotion','PromotionId','RESTRICT','CASCADE');
    //$this->addForeignKey('fk_FreeDetail_Product','FreeDetail','FreeProductId','Product','ProductId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('DiscDetail', 
                       array(
                             'OrderNo' => 'string',
                             'PromotionId' => 'string',
                             'DiscBaht' => 'decimal(20,2) DEFAULT 0',
                             'DiscPer1' => 'integer DEFAULT 0',
                             'DiscPer2' => 'integer DEFAULT 0',
                             'DiscPer3' => 'integer DEFAULT 0',
                             'DiscTotal' => 'decimal(20,2) DEFAULT 0',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (OrderNo, PromotionId)',
                             ), 'ENGINE=InnoDB');	
    $this->addForeignKey('fk_DiscDetail_ProductOrder','DiscDetail','OrderNo','ProductOrder','OrderNo','CASCADE','CASCADE');
    //$this->addForeignKey('fk_DiscDetail_Promotion','DiscDetail','PromotionId','Promotion','PromotionId','RESTRICT','CASCADE');

    // upload options
    $this->createTable('Promotion', 
                       array(
                             'PromotionGroup' => 'string not null',
                             'PromotionId' => 'string not null',
                             'StartDate' => 'date not null',
                             'EndDate' => 'date not null',
                             'PromotionType' => 'string not null',
                             'ProductOrGrpId' => 'string',
                             'MinAmount' => 'decimal(20,2) DEFAULT 0',
                             'MinSku' => 'integer DEFAULT 0',
                             'MinQty' => 'integer DEFAULT 0',
                             'Pack' => 'string',
                             'DiscBaht' => 'decimal(20,2) DEFAULT 0',
                             'DiscPerAmount' => 'decimal(20,2) DEFAULT 0',
                             'DiscPerQty' => 'integer DEFAULT 0',
                             'DiscPer1' => 'decimal(20,2) DEFAULT 0',
                             'DiscPer2' => 'decimal(20,2) DEFAULT 0',
                             'DiscPer3' => 'decimal(20,2) DEFAULT 0',
                             'FreeType' => 'string',
                             'FreeProductOrGrpId' => 'string',
                             'FreeQty' => 'integer DEFAULT 0',
                             'FreePack' => 'string',
                             'FreePerAmount' => 'decimal(20,2) DEFAULT 0',
                             'FreePerQty' => 'integer DEFAULT 0',
                             'FreeBaht' => 'decimal(20,2) DEFAULT 0',
                             'Formula' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (PromotionId)',
                             ), 'ENGINE=InnoDB');	

if ($TESTING) {
/*    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A1','2012-08-01','2013-12-30','sku','0050100003',0,0,1,'หีบ',5,0,1,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A2','2012-08-01','2013-12-30','sku','0050100003',0,0,11,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A3','2012-08-01','2013-12-30','sku','0050100003',0,0,21,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A4','2012-08-01','2013-12-30','sku','0050100003',0,0,31,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A5','2012-08-01','2013-12-30','sku','0050100003',0,0,41,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A6','2012-08-01','2013-12-30','sku','0050100003',0,0,51,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A8','2012-08-01','2013-12-30','sku','0050100001',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A9','2012-08-01','2013-12-30','sku','0050100001',1100,0,0,'',5,100,0,0,0,0,'G','A',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A10','2012-08-01','2013-12-30','sku','0050100002',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A','A11','2012-08-01','2013-12-30','sku','0050100002',1100,0,0,'',5,100,0,0,0,0,'G','A',1,'ชิ้น',100,0,0,'F',now())");
    
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M','M1','2012-08-01','2013-12-30','group','A',100,0,0,'',3,100,0,0,0,0,'S','0050100003',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M','M2','2012-08-01','2013-12-30','group','A',1000,0,0,'',5,100,0,0,0,0,'S','0050100003',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M','M3','2012-08-01','2013-12-30','group','B',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M','M4','2012-08-01','2013-12-30','group','B',1000,0,0,'',5,100,0,0,0,0,'G','A',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B1','2012-08-01','2013-12-30','bill','',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B2','2012-08-01','2013-12-30','bill','',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B3','2012-08-01','2013-12-30','bill','',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B4','2012-08-01','2013-12-30','bill','',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B5','2012-08-01','2013-12-30','bill','',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B','B6','2012-08-01','2013-12-30','bill','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A1','2012-08-01','2013-12-30','accu-all','',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A2','2012-08-01','2013-12-30','accu-all','',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A3','2012-08-01','2013-12-30','accu-all','',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A4','2012-08-01','2013-12-30','accu-all','',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A5','2012-08-01','2013-12-30','accu-all','',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A6','2012-08-01','2013-12-30','accu-all','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-A7','2012-08-01','2013-12-30','accu-all','',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B1','2012-08-01','2013-12-30','accu-l1','313',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B2','2012-08-01','2013-12-30','accu-l1','313',5000,0,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B3','2012-08-01','2013-12-30','accu-l1','313',10000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B4','2012-08-01','2013-12-30','accu-l1','313',15000,0,0,'',500,0,0,0,0,0,'G','A',0,'',0,0,200,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B5','2012-08-01','2013-12-30','accu-l1','313',20000,0,0,'',1000,0,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B6','2012-08-01','2013-12-30','accu-l1','313',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('AC','AC-B7','2012-08-01','2013-12-30','accu-l1','313',25000,0,0,'',1500,0,0,0,0,0,'','',0,'',0,0,0,'F',now())");
*/

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A1','2012-08-01','2014-12-30','sku','1000000001',0,0,1,'หีบ',5,0,1,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A2','2012-08-01','2014-12-30','sku','1000000001',0,0,11,'หีบ',5,0,1,0,0,0,'S','1000000001',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A3','2012-08-01','2014-12-30','sku','1000000001',0,0,21,'หีบ',10,0,1,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A4','2012-08-01','2014-12-30','sku','1000000001',0,0,31,'หีบ',10,0,1,0,0,0,'S','1000000001',1,'ชิ้น',0,1,0,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A5','2012-08-01','2014-12-30','sku','1000000002',100,0,0,'',5,100,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A6','2012-08-01','2014-12-30','sku','1000000002',1100,0,0,'',5,100,0,0,0,0,'S','1000000002',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A7','2012-08-01','2014-12-30','sku','1000000002',2100,0,0,'',10,100,0,0,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A8','2012-08-01','2014-12-30','sku','1000000002',3100,0,0,'',10,100,0,0,0,0,'S','1000000002',1,'ชิ้น',100,0,0,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A9','2012-08-01','2014-12-30','sku','0010500001',0,0,1,'ชิ้น',0,0,0,1,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A10','2012-08-01','2014-12-30','sku','0010500001',0,0,1,'หีบ',0,0,0,5,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A11','2012-08-01','2014-12-30','sku','0010500001',0,0,11,'หีบ',0,0,0,5,4,3,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A12','2012-08-01','2014-12-30','sku','0010500001',0,0,21,'หีบ',0,0,0,5,0,0,'S','0010500001',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S1','1A13','2012-08-01','2014-12-30','sku','0010500001',0,0,31,'หีบ',0,0,0,5,4,3,'S','0010500001',1,'ชิ้น',0,1,0,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A1','2012-08-01','2014-12-30','sku','1000000001',0,0,1,'หีบ',2,0,1,0,0,0,'','',0,'',0,0,0,'M',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A2','2012-08-01','2014-12-30','sku','1000000001',0,0,3,'หีบ',5,0,1,0,0,0,'S','1000000001',1,'ชิ้น',0,1,0,'M',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A3','2012-08-01','2014-12-30','sku','1000000001',0,0,10,'หีบ',10,0,1,0,0,0,'S','1000000001',2,'ชิ้น',0,1,0,'M',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A4','2012-08-01','2014-12-30','sku','1000000002',0,0,2,'หีบ',2,0,2,0,0,0,'','',0,'',0,0,0,'M',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A5','2012-08-01','2014-12-30','sku','1000000002',0,0,5,'หีบ',5,0,2,0,0,0,'S','1000000002',1,'ชิ้น',0,2,0,'M',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A6','2012-08-01','2014-12-30','sku','1000000002',0,0,12,'หีบ',10,0,2,0,0,0,'S','1000000002',2,'ชิ้น',0,2,0,'M',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A7','2012-08-01','2014-12-30','sku','0010500001',0,0,1,'หีบ',0,0,0,1,0,0,'','',0,'',0,0,0,'M',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A8','2012-08-01','2014-12-30','sku','0010500001',0,0,3,'หีบ',0,0,0,5,0,0,'S','0010500001',1,'ชิ้น',0,1,0,'M',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S2','2A9','2012-08-01','2014-12-30','sku','0010500001',0,0,10,'หีบ',0,0,0,5,4,3,'S','0010500001',2,'ชิ้น',0,1,0,'M',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A1','2012-08-01','2014-12-30','sku','1000000001',0,0,1,'หีบ',2,0,1,0,0,0,'','',0,'',0,0,0,'C',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A2','2012-08-01','2014-12-30','sku','1000000001',0,0,3,'หีบ',5,0,1,0,0,0,'S','1000000001',1,'ชิ้น',0,1,0,'C',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A3','2012-08-01','2014-12-30','sku','1000000001',0,0,10,'หีบ',10,0,1,0,0,0,'S','1000000001',2,'ชิ้น',0,1,0,'C',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A4','2012-08-01','2014-12-30','sku','1000000002',0,0,2,'หีบ',2,0,2,0,0,0,'','',0,'',0,0,0,'C',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A5','2012-08-01','2014-12-30','sku','1000000002',0,0,5,'หีบ',5,0,2,0,0,0,'S','1000000002',1,'ชิ้น',0,2,0,'C',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A6','2012-08-01','2014-12-30','sku','1000000002',0,0,12,'หีบ',10,0,2,0,0,0,'S','1000000002',2,'ชิ้น',0,2,0,'C',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A7','2012-08-01','2014-12-30','sku','0010500001',0,0,1,'หีบ',0,0,0,1,0,0,'','',0,'',0,0,0,'C',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A8','2012-08-01','2014-12-30','sku','0010500001',0,0,3,'หีบ',0,0,0,5,0,0,'S','0010500001',1,'ชิ้น',0,1,0,'C',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('S3','3A9','2012-08-01','2014-12-30','sku','0010500001',0,0,10,'หีบ',0,0,0,5,4,3,'S','0010500001',2,'ชิ้น',0,1,0,'C',now())");


    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M1','1M1','2012-08-01','2014-12-30','group','A',100,0,0,'',5,100,0,0,0,0,'S','0050100003',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M1','1M2','2012-08-01','2014-12-30','group','A',1000,0,0,'',10,100,0,0,0,0,'S','0050100003',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M1','1M3','2012-08-01','2014-12-30','group','B',200,0,0,'',5,200,0,0,0,0,'','',0,'',0,0,0,'C',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M1','1M4','2012-08-01','2014-12-30','group','B',2000,0,0,'',10,200,0,0,0,0,'G','B',1,'ชิ้น',200,0,0,'C',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M2','2M1','2012-08-01','2014-12-30','group','A',0,0,1,'หีบ',5,0,1,0,0,0,'S','0050100003',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M2','2M2','2012-08-01','2014-12-30','group','A',0,0,10,'หีบ',10,0,1,0,0,0,'S','0050100003',1,'ชิ้น',0,1,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M2','2M3','2012-08-01','2014-12-30','group','B',0,0,1,'หีบ',0,0,0,5,0,0,'','',0,'',0,0,0,'C',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M2','2M4','2012-08-01','2014-12-30','group','B',0,0,10,'หีบ',0,0,0,5,4,3,'G','B',1,'ชิ้น',0,1,0,'C',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M3','3M1','2012-08-01','2014-12-30','group','A',0,2,0,'',0,0,0,0,0,0,'S','0050100003',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M3','3M2','2012-08-01','2014-12-30','group','A',0,4,0,'',0,0,0,2,0,0,'S','0050100003',1,'ชิ้น',100,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M3','3M3','2012-08-01','2014-12-30','group','B',0,2,0,'',0,0,0,5,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('M3','3M4','2012-08-01','2014-12-30','group','B',0,3,0,'',0,0,0,5,4,3,'G','B',1,'ชิ้น',200,0,0,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B1','1B1','2012-08-01','2014-12-30','bill','',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B1','1B2','2012-08-01','2014-12-30','bill','',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B1','1B3','2012-08-01','2014-12-30','bill','',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B2','2B1','2012-08-01','2014-12-30','bill','',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B2','2B2','2012-08-01','2014-12-30','bill','',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B2','2B3','2012-08-01','2014-12-30','bill','',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B3','3B1','2012-08-01','2014-12-30','bill','',0,2,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B3','3B2','2012-08-01','2014-12-30','bill','',0,4,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('B3','3B3','2012-08-01','2014-12-30','bill','',0,6,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A1a','2012-08-01','2014-12-30','accu-all','',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A2a','2012-08-01','2014-12-30','accu-all','',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A3a','2012-08-01','2014-12-30','accu-all','',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A1a','2012-08-01','2014-12-30','accu-all','',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A2a','2012-08-01','2014-12-30','accu-all','',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A3a','2012-08-01','2014-12-30','accu-all','',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A1a','2012-08-01','2014-12-30','accu-all','',0,2,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A2a','2012-08-01','2014-12-30','accu-all','',0,4,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A3a','2012-08-01','2014-12-30','accu-all','',0,6,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A1l1','2012-08-01','2014-12-30','accu-l1','309',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A2l1','2012-08-01','2014-12-30','accu-l1','309',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A3l1','2012-08-01','2014-12-30','accu-l1','309',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A4l1','2012-08-01','2014-12-30','accu-l1','313',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A5l1','2012-08-01','2014-12-30','accu-l1','313',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A6l1','2012-08-01','2014-12-30','accu-l1','313',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A1l1','2012-08-01','2014-12-30','accu-l1','309',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A2l1','2012-08-01','2014-12-30','accu-l1','309',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A3l1','2012-08-01','2014-12-30','accu-l1','309',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A4l1','2012-08-01','2014-12-30','accu-l1','313',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A5l1','2012-08-01','2014-12-30','accu-l1','313',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A6l1','2012-08-01','2014-12-30','accu-l1','313',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A1l1','2012-08-01','2014-12-30','accu-l1','309',0,2,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A2l1','2012-08-01','2014-12-30','accu-l1','309',0,4,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A4l1','2012-08-01','2014-12-30','accu-l1','313',0,2,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A5l1','2012-08-01','2014-12-30','accu-l1','313',0,4,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A1l2','2012-08-01','2014-12-30','accu-l2','144',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A2l2','2012-08-01','2014-12-30','accu-l2','144',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A3l2','2012-08-01','2014-12-30','accu-l2','144',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A4l2','2012-08-01','2014-12-30','accu-l2','167',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A5l2','2012-08-01','2014-12-30','accu-l2','167',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A6l2','2012-08-01','2014-12-30','accu-l2','167',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A1l2','2012-08-01','2014-12-30','accu-l2','144',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A2l2','2012-08-01','2014-12-30','accu-l2','144',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A3l2','2012-08-01','2014-12-30','accu-l2','144',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A4l2','2012-08-01','2014-12-30','accu-l2','167',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A5l2','2012-08-01','2014-12-30','accu-l2','167',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A6l2','2012-08-01','2014-12-30','accu-l2','167',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
 
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A1l2','2012-08-01','2014-12-30','accu-l2','144',0,2,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A2l2','2012-08-01','2014-12-30','accu-l2','144',0,4,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A4l2','2012-08-01','2014-12-30','accu-l2','167',0,2,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A5l2','2012-08-01','2014-12-30','accu-l2','167',0,4,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A1l3','2012-08-01','2014-12-30','accu-l3','1',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A2l3','2012-08-01','2014-12-30','accu-l3','1',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A3l3','2012-08-01','2014-12-30','accu-l3','1',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A1l3','2012-08-01','2014-12-30','accu-l3','1',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A2l3','2012-08-01','2014-12-30','accu-l3','1',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A3l3','2012-08-01','2014-12-30','accu-l3','1',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A1l3','2012-08-01','2014-12-30','accu-l3','1',0,2,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A2l3','2012-08-01','2014-12-30','accu-l3','1',0,4,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A3','3A3l3','2012-08-01','2014-12-30','accu-l3','1',0,6,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A1s','2012-08-01','2014-12-30','accu-sku','0010100001',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A2s','2012-08-01','2014-12-30','accu-sku','0010100001',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A3s','2012-08-01','2014-12-30','accu-sku','0010100001',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A4s','2012-08-01','2014-12-30','accu-sku','0010200001',1000,0,0,'',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A5s','2012-08-01','2014-12-30','accu-sku','0010200001',2000,0,0,'',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A1','1A6s','2012-08-01','2014-12-30','accu-sku','0010200001',5000,0,0,'',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A1s','2012-08-01','2014-12-30','accu-sku','0010100001',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A2s','2012-08-01','2014-12-30','accu-sku','0010100001',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A3s','2012-08-01','2014-12-30','accu-sku','0010100001',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A4s','2012-08-01','2014-12-30','accu-sku','0010200001',0,0,10,'หีบ',0,0,0,0,0,0,'G','A',0,'',0,0,50,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A5s','2012-08-01','2014-12-30','accu-sku','0010200001',0,0,20,'หีบ',0,0,0,2,0,0,'','',0,'',0,0,0,'F',now())");
    $this->execute("INSERT INTO Promotion VALUES"
                   . "('A2','2A6s','2012-08-01','2014-12-30','accu-sku','0010200001',0,0,50,'หีบ',0,0,0,2,0,0,'G','A',0,'',0,0,150,'F',now())");

}

    // upload options
    $this->createTable('FreeGrp', 
                       array(
                             'FreeGrpId' => 'string not null',
                             'ProductId' => 'string not null',
                             'FreePack' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (FreeGrpId, ProductId)',
                             ), 'ENGINE=InnoDB');	
    //$this->addForeignKey('fk_FreeGrp_Product','FreeGrp','ProductId','Product','ProductId','RESTRICT','CASCADE');

if ($TESTING) {    
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100001','ชิ้น',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100002','ชิ้น',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100003','ชิ้น',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100004','ชิ้น',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('A','0050100005','ชิ้น',now())");

    $this->execute("INSERT INTO FreeGrp VALUES('B','0010100001','ชิ้น',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('B','0010200001','ชิ้น',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('B','0010300001','ชิ้น',now())");
    $this->execute("INSERT INTO FreeGrp VALUES('B','0010400001','ชิ้น',now())");
}

    // upload options
    $this->createTable('ProductGrp', 
                       array(
                             'ProductGrpId' => 'string not null',
                             'ProductId' => 'string not null',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ProductGrpId, ProductId)',
                             ), 'ENGINE=InnoDB');	
//   //$this->addForeignKey('fk_ProductGrp_Product','ProductGrp','ProductId','Product','ProductId','RESTRICT','CASCADE');

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

    // sale upload options
    // check
    $this->createTable('TargetSale', 
                       array(
                             'SaleId' => 'string not null',
                             'Level' => 'string not null',
                             'ProductOrGrpId' => 'string',
                             'TargetAmount' => 'integer DEFAULT 0',
                             'TargetQty' => 'integer DEFAULT 0',
                             'TargetPack' => 'string not null',
                             'UpdateAt' => 'datetime',
                             ), 'ENGINE=InnoDB');	
    //$this->addForeignKey('fk_TargetSale_SaleUnit','TargetSale','SaleId','SaleUnit','SaleId','CASCADE','CASCADE');
if ($TESTING) {
    $this->execute("INSERT INTO TargetSale VALUES('N001','all','',20000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','l1','313',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','l1','309',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','l2','167',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','l2','144',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','l3','1',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','sku','0050100001',5000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N001','sku','0050100002',0,10,'หีบ',now())");

    $this->execute("INSERT INTO TargetSale VALUES('N002','all','',20000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N002','l1','313',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N002','l2','167',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N002','sku','0050100001',5000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N002','sku','0050100002',0,10,'หีบ',now())");

    $this->execute("INSERT INTO TargetSale VALUES('N003','all','',20000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N003','l1','313',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N003','l2','167',10000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N003','sku','0050100001',5000,0,'',now())");
    $this->execute("INSERT INTO TargetSale VALUES('N003','sku','0050100002',0,10,'หีบ',now())");
}

    // transaction
    // check
    $this->createTable('ProductExchange', 
                       array(
                             'ExchangeNo' => 'string',
                             'SaleId' => 'string',
                             'CustomerId' => 'string',
                             'ExchangeDate' => 'date',
                             'InTotal' => 'decimal(20,2) DEFAULT 0',
                             'OutTotal' => 'decimal(20,2) DEFAULT 0',
                             'Paid' => 'decimal(20,2) DEFAULT 0',
                             'CashFlag' => 'char',
                             'Status' => 'string',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ExchangeNo)',
                             ), 'ENGINE=InnoDB');   
    //$this->addForeignKey('fk_ProductOrder_SaleUnit','ProductOrder','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
    //$this->addForeignKey('fk_ProductOrder_Customer','ProductOrder','CustomerId','Customer','CustomerId','RESTRICT','CASCADE');

    // transaction
    // check
    $this->createTable('ExchangeInDetail',
                       array(
                             'ExchangeNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'PriceLevel1' => 'decimal(10,2)',
                             'PriceLevel2' => 'decimal(10,2)',
                             'PriceLevel3' => 'decimal(10,2)',
                             'PriceLevel4' => 'decimal(10,2)',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ExchangeNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_ExchangeInDetail_ProductOrder','ExchangeInDetail','ExchangeNo','ProductExchange','ExchangeNo','CASCADE','CASCADE');

    // transaction
    // check
    $this->createTable('ExchangeOutDetail',
                       array(
                             'ExchangeNo' => 'string',
                             'ProductId' => 'string',
                             'QtyLevel1' => 'integer DEFAULT 0',
                             'QtyLevel2' => 'integer DEFAULT 0',
                             'QtyLevel3' => 'integer DEFAULT 0',
                             'QtyLevel4' => 'integer DEFAULT 0',
                             'PriceLevel1' => 'decimal(10,2)',
                             'PriceLevel2' => 'decimal(10,2)',
                             'PriceLevel3' => 'decimal(10,2)',
                             'PriceLevel4' => 'decimal(10,2)',
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (ExchangeNo, ProductId)',
                             ), 'ENGINE=InnoDB');   
    $this->addForeignKey('fk_ExchangeOutDetail_ProductOrder','ExchangeOutDetail','ExchangeNo','ProductExchange','ExchangeNo','CASCADE','CASCADE');

    // Synch Table
    // check
    $this->createTable('Customer', 
                       array(
                             'CustomerId' => 'string',
                             'SaleId' => 'string',
                             'Title' => 'string',
                             'CustomerName' => 'string not null',
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
                             'CreditTerm' => 'integer DEFAULT 0',
                             'CreditLimit' => 'decimal(20,2) DEFAULT 0',
                             'OverCreditType' => 'string',
                             'Due' => 'decimal(20,2) DEFAULT 0',
                             'PoseCheck' => 'decimal(20,2) DEFAULT 0',
                             'ReturnCheck' => 'decimal(20,2) DEFAULT 0',
                             'NewFlag' => 'char',
                             'DeleteFlag' => 'char',
                             'PromotionSku' => 'string', 
                             'PromotionGroup' => 'string', 
                             'PromotionBill' => 'string',
                             'PromotionAccu' => 'string', 
                             'UpdateAt' => 'datetime',
                             'PRIMARY KEY (CustomerId)',
                             ), 'ENGINE=InnoDB');
    //$this->addForeignKey('fk_Customer_SaleUnit','Customer','SaleId','SaleUnit','SaleId','SET NULL','CASCADE');
if (true) {
    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00113050001',null,'ร้าน','สุขใจ 1','CH','วันจันทร์','วันพุธ','',"
                . "'ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','33','5','สบายดี','4','พหลโยธิน',"
                . "'02-564-3333','คุณอ้อย',30,20000,'N',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00113050002',null,'ร้าน','มีดี 1','CH','วันจันทร์','วันศุกร์','',"
                . "'ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','11','2','ชมฟ้า','1','รังสิต-นครนายก',"
                . "'02-564-5555','คุณเอ',60,30000,'P',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00113050003',null,'ร้าน','ใจดี 1','CR','วันอังคาร','วันพุธ','',"
                . "'นนทบุรี','บางกรวย','บางกรวย','11130','33','5','สบายดี','4','ติวานนท์',"
                . "'02-564-6666','คุณส้ม',30,20000,'W',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00113050004',null,'ร้าน','รวยดี 1','CR','วันอังคาร','วันศุกร์','',"
                . "'นนทบุรี','บางกรวย','บางกรวย','11130','11','2','ชมฟ้า','1','ติวานนท์',"
                . "'02-564-7777','คุณรวย',60,30000,'P',0,0,0,'N','N',null,null,null,null,now());");
}
if ($TESTING) {
    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00213050001','N002','ร้าน','สุขใจ 2','CH','วันจันทร์','วันพุธ','',"
                . "'ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','33','5','สบายดี','4','พหลโยธิน',"
                . "'02-564-3333','คุณอ้อย',0,0,'N',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00213050002','N002','ร้าน','มีดี 2','CH','วันจันทร์','วันศุกร์','',"
                . "'ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','11','2','ชมฟ้า','1','รังสิต-นครนายก',"
                . "'02-564-5555','คุณเอ',0,0,'P',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00213050003','N002','ร้าน','ใจดี 2','CH','วันอังคาร','วันพุธ','',"
                . "'นนทบุรี','บางกรวย','บางกรวย','11130','33','5','สบายดี','4','ติวานนท์',"
                . "'02-564-6666','คุณส้ม',0,0,'N',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00213050004','N002','ร้าน','รวยดี 2','CH','วันอังคาร','วันศุกร์','',"
                . "'นนทบุรี','บางกรวย','บางกรวย','11130','11','2','ชมฟ้า','1','ติวานนท์',"
                . "'02-564-7777','คุณรวย',0,0,'P',0,0,0,'N','N',null,null,null,null,now());");


    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00313050001','N003','ร้าน','สุขใจ 3','CH','วันจันทร์','วันพุธ','',"
                . "'ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','33','5','สบายดี','4','พหลโยธิน',"
                . "'02-564-3333','คุณอ้อย',0,0,'N',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00313050002','N003','ร้าน','มีดี 3','CH','วันจันทร์','วันศุกร์','',"
                . "'ปทุมธานี','ธัญบุรี','บึงยี่โถ','12130','11','2','ชมฟ้า','1','รังสิต-นครนายก',"
                . "'02-564-5555','คุณเอ',0,0,'P',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00313050003','N003','ร้าน','ใจดี 3','CH','วันอังคาร','วันพุธ','',"
                . "'นนทบุรี','บางกรวย','บางกรวย','11130','33','5','สบายดี','4','ติวานนท์',"
                . "'02-564-6666','คุณส้ม',0,0,'N',0,0,0,'N','N',null,null,null,null,now());");

    $this->execute("INSERT INTO Customer VALUES"
                . "('CUD00313050004','N003','ร้าน','รวยดี 3','CH','วันอังคาร','วันศุกร์','',"
                . "'นนทบุรี','บางกรวย','บางกรวย','11130','11','2','ชมฟ้า','1','ติวานนท์',"
                . "'02-564-7777','คุณรวย',0,0,'P',0,0,0,'N','N',null,null,null,null,now());");

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

    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'A11', '0050100001', 'ชิ้น', 0.00, 12, '2013-06-08 10:04:11');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'A9', '0050100001', 'ชิ้น', 0.00, 38, '2013-06-08 10:04:02');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100001', 'ชิ้น', 0.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100002', 'ชิ้น', 0.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100003', 'ชิ้น', 0.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100004', 'ชิ้น', 0.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050001', 'M4', '0050100005', 'ชิ้น', 5.00, 1, '2013-06-08 10:04:28');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M2', '0050100003', 'ชิ้น', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100001', 'ชิ้น', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100002', 'ชิ้น', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100003', 'ชิ้น', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100004', 'ชิ้น', 0.00, 2, '2013-06-08 10:05:35');");
    $this->execute("INSERT INTO `FreeDetail` VALUES('SOD00113050002', 'M4', '0050100005', 'ชิ้น', 5.00, 2, '2013-06-08 10:05:35');");

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
        if (strcmp($table, 'tbl_migration') != 0 && strcmp($table, 'Location') != 0)
            $this->dropTable($table);
    }
  }
}
