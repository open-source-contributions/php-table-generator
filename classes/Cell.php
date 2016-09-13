<?php
/**
 * Contains Cell class
 */

/**
 * Class Cell
 */
class Cell extends TableGenerator
{
    /**
     * cell content
     *
     * @var string $content
     */
    public $content;

    /**
     * cell rowspan
     *
     * @var $rowspan
     */
    private $rowspan;

    /**
     * cell colspan
     *
     * @var $colspan
     */
    private $colspan;

    /**
     * cell scope
     *
     * @var $scope
     */
    private $scope;

    /**
     * array of possible scope values
     *
     * @var array $scopeWhiteList
     */
    private $scopeWhiteList;

    /**
     * initialize a cell object
     *
     * @param string $content
     * @param bool   $htmlspecialchars
     */
    public function __construct($content = '', $htmlspecialchars = false)
    {
        $content = $htmlspecialchars === true ? htmlspecialchars($content, ENT_QUOTES) : $content;
        $this->setContent($content);

        $this->scopeWhiteList = array('col', 'row', 'colgroup', 'rowgroup');
    }

    /**
     * add rowspan to a cell
     *
     * @param $rowspan
     */
    public function addRowspan($rowspan)
    {
        try {
            if (isset($rowspan) && is_numeric($rowspan) && $rowspan > 0) {
                $this->rowspan = $rowspan;
            } else {
                throw new TableException('rowspan in addRowspan() must be numeric and greater than zero');
            }
        } catch (TableException $e) {
            $e->displayError();
        }
    }

    /**
     * add colspan to a cell
     *
     * @param $colspan
     */
    public function addColspan($colspan)
    {
        try {
            if (isset($colspan) && is_numeric($colspan) && $colspan > 0) {
                $this->colspan = $colspan;
            } else {
                throw new TableException('colspan in addColspan() must be numeric and greater than zero');
            }
        } catch (TableException $e) {
            $e->displayError();
        }
    }

    /**
     * add scope to a cell
     *
     * scope can only be 'col', 'row', 'colgroup' or 'rowgroup'
     *
     * @param $scope
     */
    public function addScope($scope)
    {
        try {
            if (in_array($scope, $this->scopeWhiteList)) {
                $this->scope = $scope;
            } else {
                $scopeWhiteList = implode(', ', $this->scopeWhiteList);
                throw new TableException("scope in addScope() must be one of these values: {$scopeWhiteList}");
            }
        } catch (TableException $e) {
            $e->displayError();
        }
    }

    /**
     * return scope for a cell
     *
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * return rowspan for a cell
     *
     * @return mixed
     */
    public function getRowspan()
    {
        return $this->rowspan;
    }

    /**
     * return colspan for a cell
     *
     * @return mixed
     */
    public function getColspan()
    {
        return $this->colspan;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
