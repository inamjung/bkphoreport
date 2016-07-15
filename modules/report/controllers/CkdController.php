<?php
namespace app\modules\report\controllers;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class CkdController extends controller {
    
//    public function actionGfrlowbyamp() {
//
//
//        $connection = Yii::$app->db2;
//        $data = $connection->createCommand("  SELECT v.ampurcode,v.c_ampurname,v.villagecodefull,v.villagename
//        ,c.cc 
//        ,t.ct
//        FROM 
//        tmp_38_village_latlng v
//
//        LEFT OUTER JOIN(
//        SELECT COUNT(DISTINCT c.cid) AS cc,p_pt_vhid FROM hdc.t_chronic c
//        INNER JOIN tmp_38_village_latlng v ON v.villagecodefull=c.p_pt_vhid
//        WHERE 
//        (c.diagcode LIKE 'N18%' 
//        or c.diagcode in ('E102','E112','E122','E132','E142','I151')
//        or c.diagcode like 'I12%'
//        or c.diagcode like 'I13%')
//        GROUP BY villagecodefull
//        ) c ON c.p_pt_vhid=v.villagecodefull
//
//        LEFT OUTER JOIN(
//        SELECT COUNT(DISTINCT t.cid) AS ct,villagecodefull FROM t_bkhdc_ckd_gfr_decline59 t
//        GROUP BY villagecodefull
//        ) t ON v.villagecodefull=t.villagecodefull
//
//        GROUP BY v.ampurcode ")->queryAll();
//
//        for ($i = 0; $i < sizeof($data); $i++) {
//            $ampurcode[] = $data[$i]['ampurcode'];
//            $cc[] = $data[$i]['cc'] * 1;
//            $ct[] = $data[$i]['ct'] * 1;
//            $c_ampurname[] = $data[$i]['c_ampurname'];
//        }
//
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => $data,
//        ]);
//        return $this->render('gfrlowbyamp', [
//                    'dataProvider' => $dataProvider,
//                    'ampurcode' => $ampurcode,
//                    'cc' => $cc,
//                    'ct' => $ct,
//                    'c_ampurname' => $c_ampurname,
//        ]);
//    }
    public function actionGfrlowbyamp(){        
        
        $sql = "SELECT 
                s.stat
                ,s.y_proc
                ,s.m_proc
                ,tv.ampurcode AS u_code
                ,tv.c_ampurname AS u_name
                ,SUM(s.A) AS A
                ,SUM(s.B) AS B
                ,(s.B/s.A)*100 AS rate
                ,SUM(s.stage1) AS stage1
                ,SUM(s.stage2) AS stage2
                ,SUM(s.stage3) AS stage3
                ,SUM(s.stage4) AS stage4
                ,SUM(s.stage5) AS stage5

                FROM s_bkhdc_ckd_gfr s
                INNER JOIN tmp_38_village_latlng tv ON s.villagecodefull=tv.villagecodefull
                WHERE s.stat='y'
                GROUP BY tv.ampurcode";
        
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
        ]);
        
        
        return $this->render('gfrlowbyamp',[
            'dataProvider'=>$dataProvider,
            'rawData' => $rawData,
            'sql' => $sql,
            //'ampurcode'=>$ampurcode
        ]);        
    }
    
    public function actionIndivgfrlowbytam($ampurcode = null) {

        $sql = "SELECT 
                s.stat
                ,s.y_proc
                ,s.m_proc
                ,tv.tamboncode AS u_code
                ,tv.c_tambonname AS u_name
                ,SUM(s.A) AS A
                ,SUM(s.B) AS B
                ,(s.B/s.A)*100 AS rate
                ,SUM(s.stage1) AS stage1
                ,SUM(s.stage2) AS stage2
                ,SUM(s.stage3) AS stage3
                ,SUM(s.stage4) AS stage4
                ,SUM(s.stage5) AS stage5

                FROM s_bkhdc_ckd_gfr s
                INNER JOIN tmp_38_village_latlng tv ON s.villagecodefull=tv.villagecodefull
                WHERE tv.ampurcode='$ampurcode' AND s.stat='y'
                GROUP BY tv.ampurcode,tv.tamboncode ";
        
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
        ]);
        return $this->render('indivgfrlowbytam', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData,
                    'sql' => $sql,    
                    'ampurcode'=>$ampurcode
        ]);
    }
    public function actionIndivgfrlowbyvill($tamboncode = null,$villagecodefull=NULL) {

        $sql = "SELECT 
            s.stat
            ,s.y_proc
            ,s.m_proc
            ,tv.villagecodefull AS u_code
            ,tv.villagename AS u_name
            ,s.A
            ,s.B
            ,s.rate
            ,s.stage1
            ,s.stage2
            ,s.stage3
            ,s.stage4
            ,s.stage5

            FROM s_bkhdc_ckd_gfr s
            INNER JOIN tmp_38_village_latlng tv ON s.villagecodefull=tv.villagecodefull
            WHERE tv.tamboncode ='$tamboncode'  AND s.stat='y'";
        
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
        ]);
        return $this->render('indivgfrlowbyvill', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData,
                    'sql' => $sql,    
                    'tamboncode'=>$tamboncode,
                    //'ampurcode'=>$ampurcode,
                   'villagecodefull'=>$villagecodefull
        ]);
    }
    
    public function actionIndivgfrlowbycid($tamboncode = null,$ampurcode=null,$villagecodefull=null) {

        $sql = "SELECT 
            p.`NAME`,
            p.LNAME,
            p.HID,
            h.LATITUDE,
            h.LONGITUDE,
            t.*
            FROM t_bkhdc_ckd_gfr_decline59 t
            INNER JOIN hdc.person p ON p.CID=t.cid
            INNER JOIN hdc.home h ON h.HID=p.HID 
            AND CONCAT('38',h.AMPUR,h.TAMBON,h.VILLAGE)='$villagecodefull'

            WHERE t.villagecodefull='$villagecodefull'

            GROUP BY cid
            ORDER BY villagecodefull,gfr59_stage DESC";
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
        ]);
        return $this->render('indivgfrlowbycid', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData,
                    'sql' => $sql,    
                    'tamboncode'=>$tamboncode,
                    'ampurcode'=>$ampurcode,
                    'villagecodefull'=>$villagecodefull
        ]);
    }
}

