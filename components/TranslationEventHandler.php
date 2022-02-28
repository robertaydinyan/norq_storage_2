<?php

namespace app\components;

use app\models\Message;
use app\models\SourceMessage;
use Yii;
use yii\i18n\MissingTranslationEvent;

class TranslationEventHandler
{
    public static function handleMissingTranslation(MissingTranslationEvent $event)
    {
        if (strncmp($event->category, 'app', 3) === 0) {
            $SourceMessage = SourceMessage::find()->where(['category' => $event->category, 'message' => $event->message])->one();
            if (!$SourceMessage) {
                $SourceMessage = new SourceMessage();
                $SourceMessage->message = $event->message;
                $SourceMessage->category = $event->category;
                $SourceMessage->save();
            }
            $language = Yii::$app->language;
            $source = 'en';
            if (strncmp($event->category, 'app_ru', 6) === 0) {
                $source = 'ru';
            }
            try{
                $findTranlationRu = Yii::$app->translate->translate($source, $language, $SourceMessage->message);
            }
            catch(\Exception $exeption){
                $findTranlationRu['code'] = 400;
            }

            if ($findTranlationRu['code'] == '200') {
                $tranlation = $findTranlationRu['text'][0];
            } else {
                $tranlation = $SourceMessage->message;
            }
            $checkMessageExistsRu = Message::find()->where(['language' => $language, 'id' => $SourceMessage->id])->exists();
            if (!$checkMessageExistsRu) {
                $message = new Message();
                $message->id = $SourceMessage->id;
                $message->translation = $tranlation;
                $message->language = $language;
                $message->save();
            }
        } else {
            $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
        }

    }
}