<?php
namespace app\modules\report\controllers;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class CkdController extends controller {
    
    
    public function actionGfrlowbyamp(){        
        
//        $sql = "SELECT COUNT(g.cid) total,v.ampurcode,v.c_ampurname 
//            FROM t_bkhdc_ckd_gfr_decline59 g
//            INNER JOIN tmp_38_village_latlng v on g.villagecodefull=v.villagecodefull
//            GROUP BY v.ampurcode";
        
        $sql="SELECT v.ampurcode,v.c_ampurname,v.villagecodefull,v.villagename
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

        GROUP BY v.ampurcode";
        
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rawData,
        ]);
        
//        $dataProvider = new ArrayDataProvider([
//            'allModels'=>$data,
//            'sort'=>[
//                'attributes'=>['ampurcode','total','c_ampurname']
//            ],
//        ]);
        return $this->render('gfrlowbyamp',[
            'dataProvider'=>$dataProvider,
            'rawData' => $rawData,
            'sql' => $sql,
            //'ampurcode'=>$ampurcode
        ]);        
    }
    
    public function actionIndivgfrlowbytam($ampurcode = null) {

//        $sql = "SELECT COUNT(g.cid) total,v.tamboncode,v.c_tambonname,v.ampurcode,v.c_ampurname 
//                FROM t_bkhdc_ckd_gfr_decline59 g
//                INNER JOIN tmp_38_village_latlng v on g.villagecodefull=v.villagecodefull
//                where ampurcode='$ampurcode'
//                GROUP BY v.tamboncode ";
        $sql = "SELECT v.ampurcode,v.c_ampurname,v.tamboncode,v.c_tambonname
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
WHERE v.ampurcode ='$ampurcode'
GROUP BY v.tamboncode
 ";
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

