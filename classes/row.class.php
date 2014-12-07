<?php
    /**
     * Contains Row class
     */

    if (count(get_included_files()) === 1)
        exit('Direct access to ' . __FILE__ . ' not permitted.');

    /**
     * Class Row
     */
    class Row extends TableGenerator
    {
        /**
         * array of row cells
         *
         * @var array $cells
         */
        private $cells;

        /**
         * initialize a row object
         *
         * @param array $cells
         */
        public function __construct(array $cells = array())
        {
            $this->addCells($cells);
        }

        /**
         * add cells to a row
         *
         * @param array $cells
         */
        public function addCells(array $cells)
        {
            $this->cells = $cells;
        }

        /**
         * add a cell to a row
         *
         * by default, cell is added to the end of row. The position can be specified using index starting from 0
         *
         * @param Cell $cell
         * @param int  $index
         */
        public function addCell(Cell $cell, $index = -1)
        {
            try {
                if (is_numeric($index) && ($cell instanceof Cell)) {
                    $cells = $this->cells;

                    if ($index === -1) {
                        // add to the end of the rows array
                        $cells[] = $cell;

                    } else {
                        // insert the item in
                        array_splice($cells, $index, 0, array($cell));
                    }

                    $this->cells = $cells;

                } else
                    throw new TableException('index in addCell() must be numeric');
            } catch (TableException $e) {
                $e->displayError();
            }
        }

        /**
         * return cells for a row
         *
         * @return mixed
         */
        public function getCells()
        {
            return $this->cells;
        }

        /**
         * return html for a row
         *
         * @param string $type
         *
         * @return string
         */
        public function getHtml($type = '')
        {
            $attributesHtml = $this->getAllAttributesHtml();

            $html = "<tr {$attributesHtml}>";

            // get cells
            $cells = $this->cells;

            foreach ($cells as $cell) {
                if ($cell !== '' && $cell instanceof Cell) {
                    // get cell content
                    $content = $cell->content;

                    $attributesHtml = $cell->getAllAttributesHtml();

                    // specify start and end tag based on cell type
                    $htmlTag = ($type === 'head') ? 'th' : 'td';

                    // get scope
                    $scope = $cell->getScope();

                    if (isset($scope))
                        $scopeHtml = "scope = \"{$scope}\"";
                    else
                        $scopeHtml = '';

                    // get rowspan
                    $rowspan = $cell->getRowspan();

                    if (isset($rowspan))
                        $rowspanHtml = "rowspan = \"{$rowspan}\"";
                    else
                        $rowspanHtml = '';

                    // get colspan
                    $colspan = $cell->getColspan();

                    if (isset($colspan))
                        $colspanHtml = "colspan = \"{$colspan}\"";
                    else
                        $colspanHtml = '';

                    $html .= "<{$htmlTag} {$rowspanHtml} {$colspanHtml} {$attributesHtml} {$scopeHtml}>{$content}</{$htmlTag}>";
                }
            }

            $html .= '</tr>';

            return $html;
        }

    }