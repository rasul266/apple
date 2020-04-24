<?php

namespace backend\controllers;

use common\models\Apple;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\Exception;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */


    /**
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Apple::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEat($id,$percent)
    {
        $id = Yii::$app->request->get('id');
        $percent = Yii::$app->request->get('percent');

        $apple = $this->findModel($id);

        if($percent > Apple::MAX_SIZE or $percent < Apple::MIN_SIZE) {
            throw new Exception('Процент должен быть больше или равно 100 и больше 0');
        }

        if($apple->isHaving() or $apple->isRotten()){
            throw new Exception('Когда висит на дереве или испорчено, то съесть нельзя.');
        }

        if($apple->eat($percent))
        {
            $apple->save();
        }

        return $this->redirect(['index']);
    }




    public function actionFall(int $id){

        $apple = $this->findModel($id);

        if($apple->isHaving())
        {
            $apple->fallToGround();
            $apple->save();

        }else{

            Throw new Exception('Яблоко уже лежит на земле !!!');

        }

        return $this->redirect(['index']);
    }



    public function actionGenerate()
    {
        $model = new Apple();

        $applesCount = rand(7,25);

        for ($i=0; $i<$applesCount; $i++) {

            $colorForApple = $model->colorList[rand(0,count($model->colorList)-1)];

            $apple = new Apple($colorForApple);
            $apple->save();
        }

       return $this->redirect(['/apple/index']);
    }



    public function actionDelete($id)
    {
        $apple = $this->findModel($id);

        if($apple->isEaten())
        {
            $apple->delete();

        }else{
            throw new Exception('Чтобы удалить, надо сначала съесть яблоко!!');
        }

        return $this->redirect(['index']);
    }



    protected function findModel($id)
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
