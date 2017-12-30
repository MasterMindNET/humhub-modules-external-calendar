<?php

namespace humhub\modules\external_calendar\widgets;

use humhub\modules\external_calendar\assets\Assets;
use humhub\modules\external_calendar\permissions\ManageEntry;
use Yii;

/**
 * @inheritdoc
 */
class WallEntry extends \humhub\modules\content\widgets\WallEntry
{
    /**
     * @var string
     */
    public $managePermission = ManageEntry::class;

    /**
     * @inheritdoc
     */
    public $editRoute = "/external_calendar/entry/update";

    /**
     * @inheritdoc
     */
    public $editMode = self::EDIT_MODE_MODAL;

    /**
     * @var bool defines if the description and location info should be cut at a certain height, this should only be the case in the stream
     */
    public $stream = true;

    /**
     * @var bool defines if the content should be collapsed
     */
    public $collapse = true;

    /**
     * @inheritdoc
     */
    public $showFiles = false;

    public function getContextMenu()
    {
        $canEdit = $this->contentObject->content->canEdit();
        if (!$canEdit) {
            $this->controlsOptions['prevent'] = [\humhub\modules\content\widgets\EditLink::class, \humhub\modules\content\widgets\DeleteLink::class];
        }
        $this->controlsOptions['prevent'] = [\humhub\modules\content\widgets\VisibilityLink::class];

        return parent::getContextMenu(); // TODO: Change the autogenerated stub
    }

    public function getWallEntryViewParams()
    {
        $params = parent::getWallEntryViewParams();
        if ($this->isInModal()) {
            $params['showContentContainer'] = true;
        }
        return $params;
    }

    public function isInModal()
    {
        return Yii::$app->request->get('cal');
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        Assets::register($this->getView());
        $entry = $this->contentObject;

        return $this->render('wallEntry', [
            'calendarEntry' => $entry,
            'collapse' => $this->collapse,
            'contentContainer' => $entry->content->container
        ]);
    }

}
