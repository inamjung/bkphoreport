<?php
namespace app\modules\report\controllers;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ReportdmController extends Controller{
    
    public function actionPersondm() {
        
        $sql = "SELECT HOSPCODE,CID,PID,CONCAT(PRENAME,`NAME`,' ',LNAME) pname , SEX,BIRTH FROM t_person_dm
limit 12";
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => false,
        ]);
        return $this->render('persondm', [
                    'dataProvider' => $dataProvider,
                    'sql' => $sql,                    
        ]);
    }
    
    public function actionReport1(){
        $connection = Yii::$app->db2;
        $data = $connection->createCommand('
            SELECT year(t.DATETIME_DISCH) as yy,
            month(t.DATETIME_DISCH) as mm,
            COUNT(t.AN) as cnt
            FROM admission t
            GROUP BY yy,mm
            ORDER BY yy,mm
            ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for($i=0;$i<sizeof($data);$i++){
            $yy[] = $data[$i]['yy'];
            $mm[] = $data[$i]['yy'].'-'.$data[$i]['mm'];
            $cnt[] = $data[$i]['cnt'];
        }
        
        $dataProvider = new ArrayDataProvider([
            'allModels'=>$data,
            'sort'=>[
                'attributes'=>['yy','mm','cnt']
            ],
        ]);
        return $this->render('report1',[
            'dataProvider'=>$dataProvider,
            'yy'=>$yy,'mm'=>$mm,'cnt'=>$cnt,
        ]);
    }
    public function actionReport2(){
        $connection = Yii::$app->db;
        $data = $connection->createCommand('
            SELECT year(t.DATETIME_DISCH) as yy, 
            month(t.DATETIME_DISCH) as mm, 
            count(t.AN) as cnt, 
            sum(t.ADJRW) as sumadj, 
            round(avg(t.ADJRW),4) as cmi , 
            sum(t.ACTLOS) as los, 
            round(avg(t.ACTLOS),2) as los_per_case
            FROM admission t  
            GROUP BY yy,mm
            ORDER BY yy,mm
            ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for($i=0;$i<sizeof($data);$i++){
            $yy[] = $data[$i]['yy'];
            $mm[] = $data[$i]['yy'].'-'.$data[$i]['mm'];
            $cnt[] = $data[$i]['cnt'];
            $sumadj[] = $data[$i]['sumadj'];
            $cmi[] = $data[$i]['cmi'];
            $los[] = $data[$i]['los'];
            $los_per_case[] = $data[$i]['los_per_case'];
        }
        
        $dataProvider = new ArrayDataProvider([
            'allModels'=>$data,
            'sort'=>[
                'attributes'=>['yy','mm','cnt','sumadj','cmi','los','los_per_case']
            ],
        ]);
        return $this->render('report2',[
            'dataProvider'=>$dataProvider,
            'yy'=>$yy,'mm'=>$mm,'cnt'=>$cnt,'sumadj'=>$sumadj,'cmi'=>$cmi,'los'=>$los,'los_per_case'=>$los_per_case
        ]);
    }
    public function actionReport3(){
        if(isset($_POST['year'])){
            $y = "AND year(t.DATETIME_DISCH)='".$_POST['year']."' ";
            $y .= '';
        }else{
            $y = '';
        }
        $connection = Yii::$app->db;
        $data = $connection->createCommand('
            SELECT year(t.DATETIME_DISCH) as yy, 
            month(t.DATETIME_DISCH) as mm, 
            count(t.AN) as cnt, 
            sum(t.ADJRW) as sumadj, 
            sum(t.ADJRW)/sum(if(ADJRW>0,1,0)) as cmi ,
            sum(t.ACTLOS) as los, 
            avg(t.ACTLOS) as los_per_case
            FROM admission t  
            WHERE 1=1 '.$y.' 
            GROUP BY yy,mm
            ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for($i=0;$i<sizeof($data);$i++){
            $yy[] = $data[$i]['yy'];
            $mm[] = $data[$i]['yy'].'-'.$data[$i]['mm'];
            $cnt[] = $data[$i]['cnt'];
            $sumadj[] = $data[$i]['sumadj'];
            $cmi[] = $data[$i]['cmi'];
            $los[] = $data[$i]['los'];
            $los_per_case[] = $data[$i]['los_per_case'];
        }
        
        $dataProvider = new ArrayDataProvider([
            'allModels'=>$data,
            'sort'=>[
                'attributes'=>['yy','mm','cnt','sumadj','cmi','los','los_per_case']
            ],
        ]);
        return $this->render('report3',[
            'dataProvider'=>$dataProvider,
            'yy'=>$yy,'mm'=>$mm,'cnt'=>$cnt,'sumadj'=>$sumadj,'cmi'=>$cmi,'los'=>$los,'los_per_case'=>$los_per_case
        ]);
    }
    
}
