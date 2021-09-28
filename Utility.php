<?php
/********************************************************************************
 *                        .::ALGOL-TEAM PRODUCTIONS::.                           *
 *    .::Author © 2021 | algol.team.uz@gmail.com | github.com/algol-team::.      *
 *********************************************************************************
 *  Description: This is class for PHP.                                          *
 *  Thanks to specialist: All PHP masters.                                       *
 ********************************************************************************/

use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\AssetBundle;

/**
 * ALGOL_YII
 *
 * @category  Class
 * @package   Utility-Yii2
 * @author    AlgolTeam <algol.team.uz@gmail.com>
 * @copyright Copyright (c) 2021
 * @link      https://github.com/algol-team
 */

class ALGOL_YII {

    /**
     ** onclick function(model, key, index) {value, url, data, expand}
     ** loading string
     * @return string
     */
    public static function GridColumnExpandOf() {
        return GridColumnExpandOf::class;
    }
}

/**
 * GridColumnExpandOf
 *
 * @category  Class
 * @package   Utility-Yii2
 * @author    AlgolTeam <algol.team.uz@gmail.com>
 * @copyright Copyright (c) 2021
 * @link      https://github.com/algol-team
 */

class GridColumnExpandOf extends DataColumn {
    const EXPANDED_CLASS = 'expand-column';
    const REDIRECT = 'redirect';

    public $enableCache = true;
    public $loading = '<center><h6><i>Please, wait...</i></h6></center>';
    public $onclick;

    private $url_expand;
    private $url_goto;
    private $column_id;

    /**
     *
     */
    public function init() {
        parent::init();
        if (isset($this->onclick)) {
            $this->url_expand = null;
            $this->url_goto = null;
            $this->column_id = md5(VarDumper::dumpAsString(get_object_vars($this), 5));
            ExpandColumnAsset::register($this->grid->getView());
        }
    }

    /**
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return string
     */
    public function renderDataCell($model, $key, $index) {
        if ($this->onClick($FResult, $model, $key, $index)) {
            return Html::beginTag('td', $FResult['options'])
                . $FResult['content']
                . Html::endTag('td');
        }
        return parent::renderDataCell($model, $key, $index);
    }

    /**
     * @param $AResult
     * @param $model
     * @param $key
     * @param $index
     * @return bool
     */
    private function onClick(&$AResult, $model, $key, $index) {
        $AResult = null;
        $FOnClick = ALGOL::ArrayOf()->FromFunction($this->onclick, $model, $key, $index);
        if (ALGOL::ArrayOf()->Length($FOnClick) > 1) {
            if (ALGOL::StrOf()->Length($FOnClick['value'], true) > 0) {
                $AResult['content'] = $FOnClick['value'];
                if (ALGOL::DefaultOf()->TypeCheck($AResult['content'], DTC_HTML)) $this->format = 'raw';
            }
            if (ALGOL::StrOf()->Length($FOnClick['url'], true) > 0) {
                $FOptions = ALGOL::ArrayOf()->FromFunction($this->contentOptions, $model, $key, $index);
                if (ALGOL::DefaultOf()->ValueCheck($FOnClick['expand'], true)) {
                    if (is_null($this->url_expand)) {
                        $this->url_expand = $FOnClick['url'];
                        $this->regScript(true);
                    }
                    $FOptions['data-row_id'] = $this->normalizeRowID($key);
                    $FOptions['data-col_id'] = $this->column_id;
                    $FClass = self::EXPANDED_CLASS . CH_MINUS . $this->column_id;
                } else {
                    if (is_null($this->url_goto)) {
                        $this->url_goto = $FOnClick['url'];
                        $this->regScript(false);
                    }
                    $FClass = self::EXPANDED_CLASS . CH_MINUS . self::REDIRECT;
                }
                $FOptions['class'] = $FClass . (isset($FOptions['class']) ? " {$FOptions['class']}" : CH_FREE);
                if (ALGOL::ArrayOf()->Length($FOnClick['data']) > 0) $FOptions['data-info'] = $FOnClick['data']; else $FOptions['data-info'] = is_array($key) ? $key : ['id' => $key];
                $AResult['options'] = $FOptions;
            }
        }
        return isset($AResult);
    }

    /**
     * @param bool $AExpand
     */
    private function regScript($AExpand = true) {
        if (Yii::$app->getRequest()->getIsAjax()) return;
        if ($AExpand) {
            $FClass = $FClass = self::EXPANDED_CLASS . CH_MINUS . $this->column_id;
            $FOptions = Json::encode(['url' => $this->url_expand,
                'countColumns' => count($this->grid->columns),
                'enableCache' => (bool)$this->enableCache,
                'loading' => $this->loading,
                'hideEffect' => 'fadeOut',
                'showEffect' => 'fadeIn',
                'redirect' => false]);
        } else {
            $FClass = $FClass = self::EXPANDED_CLASS . CH_MINUS . self::REDIRECT;
            $FOptions = Json::encode(['url' => $this->url_goto, 'redirect' => true]);
        }

        $js = <<<JS
            jQuery(document).on('click', '#{$this->grid->getId()} .{$FClass}', function() {
                var row = new ExpandRow({$FOptions});
                row.run($(this));
            });
JS;
        return $this->grid->getView()->registerJs($js);
    }

    /**
     * @param $rowID
     * @return string
     */
    protected function normalizeRowID($rowID) {
        if (is_array($rowID)) {
            $rowID = implode('', $rowID);
        }
        return trim(preg_replace("|[^\d\w]+|iu", '', $rowID));
    }
}

/**
 * ExpandColumnAsset
 *
 * @category  Class
 * @package   Utility-Yii2
 * @author    AlgolTeam <algol.team.uz@gmail.com>
 * @copyright Copyright (c) 2021
 * @link      https://github.com/algol-team
 */

class ExpandColumnAsset extends AssetBundle {
    public $sourcePath = '@vendor/algol-team/library-yii2/assets';
    public $js = ['js/expand-column.js'];
    public $css = ['css/expand-column.css'];
    public $depends = ['yii\web\JqueryAsset'];
}