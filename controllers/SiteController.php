<?php 

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\User;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'login', 'signup', 'index', 'about', 'contact', 'request-password-reset', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['login', 'signup', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'], // Guests can access these actions
                    ],
                    [
                        'actions' => ['logout', 'index', 'about', 'contact'],
                        'allow' => true,
                        'roles' => ['@'], // Authenticated users only
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']); // Redirect guests to login page
        }
        return $this->render('index');
    }

    /**
     * Login action.
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome(); // Redirect if already logged in
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack(); // Redirect to previous page after login
        }

        $model->password = ''; // Clear password field
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Signup action.
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $user = $model->signup()) {
            Yii::$app->user->login($user);
            return $this->goHome();
        }
        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Logout action.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout(); // Log the user out
        Yii::$app->session->destroy(); // Destroy session
        return $this->redirect(['site/login']);
    }

    /**
     * Displays contact page.
     */
    public function actionContact()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']); // Redirect guests to login page
        }
        
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }

        return $this->render('contact', ['model' => $model]);
    }

    /**
     * Displays about page.
     */
    public function actionAbout()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']); // Redirect guests to login page
        }
        return $this->render('about');
    }

    /**
     * Request password reset.
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->sendEmail()) {
            Yii::$app->session->setFlash('success', 'Check your email for the password reset link.');
            return $this->goHome();
        }
        
        return $this->render('requestPasswordReset', ['model' => $model]);
    }

    /**
     * Reset password action.
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (\yii\web\BadRequestHttpException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Password successfully changed.');
            return $this->redirect(['site/login']);
        }

        return $this->render('resetPassword', ['model' => $model]);
    }
}
