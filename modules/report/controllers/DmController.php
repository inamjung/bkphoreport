<?php
namespace app\modules\report\controllers;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class DmController extends controller {
    
    public function actionDmregbyamp() {


        $connection = Yii::$app->db2;
        $data = $connection->createCommand(" SELECT * FROM t_person_dm_amp_summary ")->queryAll();

//        for ($i = 0; $i < sizeof($data); $i++) {
//            $ampurcode[] = $data[$i]['ampurcode'];
//            $cc[] = $data[$i]['cc'] * 1;
//            $ct[] = $data[$i]['ct'] * 1;
//            $c_ampurname[] = $data[$i]['c_ampurname'];
//        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dmregbyamp', [
                    'dataProvider' => $dataProvider,
                    'data'=>$data
//                    'c_ampurcodefull' => $c_ampurcodefull,
//                    'regandunreg' => $regandunreg,
//                    'reg' => $reg,
//                    'c_ampurname' => $c_ampurname,
        ]);
    }

    public function actionIndivdmregbytam($ampurcode = null) {

        $sql = " SELECT * FROM t_person_dm_tmb_summary
                WHERE c_ampurcodefull='$ampurcode'";
        
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
        ]);
        return $this->render('indivdmregbytam', [
                    'dataProvider' => $dataProvider,
                    'rawData' => $rawData,
                    'sql' => $sql,    
                    'ampurcode'=>$ampurcode
        ]);
    }
    public function actionIndivgfrlowbyvill($tamboncode = null,$ampurcode=null,$villagecodefull=null) {

//        $sql = "SELECT COUNT(g.cid) total,g.villagecodefull,v.villagecode,v.villagename,v.tamboncode,v.ampurcode
//        ,v.c_tambonname,v.c_ampurname,v.LATITUDE,v.LONGITUDE
//        FROM t_bkhdc_ckd_gfr_decline59 g
//        INNER JOIN tmp_38_village_latlng v on g.villagecodefull=v.villagecodefull
//        WHERE v.tamboncode='$tamboncode'
//        GROUP BY v.villagecodefull";
        $sql="SELECT v.tamboncode,v.villagecodefull,v.villagename
,c.cc 
,t.ct
FROM 
tmp_38_village_latlng v

LEFT OUTER JOIN(
SELECT COUNT(DISTINCT c.cid) AS cc,p_pt_vhid FROM hdc.t_chronic c
INNER JOIN tmp_38_village_latlng v ON v.villagecodefull=c.p_pt_vhid
WHERE 
(c.diagcode LIKE 'N18%' 
or c.diagcode in ('E102','E112','E122','E132','E142','I151')
or c.diagcode like 'I12%'
or c.diagcode like 'I13%')
GROUP BY villagecodefull
) c ON c.p_pt_vhid=v.villagecodefull

LEFT OUTER JOIN(
SELECT COUNT(DISTINCT t.cid) AS ct,villagecodefull FROM t_bkhdc_ckd_gfr_decline59 t
GROUP BY villagecodefull
) t ON v.villagecodefull=t.villagecodefull
WHERE v.tamboncode ='$tamboncode'
GROUP BY v.villagecodefull";
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
                    'ampurcode'=>$ampurcode,
                    'villagecodefull'=>$villagecodefull
        ]);
    }
    
    public function actionIndivgfrlowbycid($tamboncode = null,$ampurcode=null,$villagecodefull=null) {

        $sql = "SELECT g.villagecodefull,v.villagecode,v.villagename,g.cid
            ,g.qof58_gfr,g.qof59_gfr,g.gfr_decline 
            FROM t_bkhdc_ckd_gfr_decline59 g
            INNER JOIN tmp_38_village_latlng v on g.villagecodefull=v.villagecodefull
            WHERE g.villagecodefull='$villagecodefull'";
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

