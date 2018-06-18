<?php 

class Pagination
{
    public $currentPage;
    public $perPage;
    public $totalItemsAmount;
    public $totalPagesAmount;
    public $midSize;
    public $pages = [];
    public $previous;
    public $next;

    /**
     * @param int $currentPage        Current page number.
     * @param int $perPage            Number of items displayed per page.
     * @param int $totalItemsAmount   Total number of items.
     * @param int $midSize            Number of page numbers on each side of current page.
     */
    public function __construct($currentPage, $totalItemsAmount, $perPage = 10, $midSize = 2)
    {
        $this->currentPage = (int)$currentPage;
        $this->totalItemsAmount = $totalItemsAmount;
        $this->totalPagesAmount = ceil($totalItemsAmount / $perPage);
        $this->perPage = $perPage;
        $this->midSize = $midSize;

        $this->init();
    }

    private function init()
    {
        $current = $this->currentPage;
        $midSize = $this->midSize;
        $totalPagesAmount = $this->totalPagesAmount;

        $start = $current - $midSize;
        // start page number can't be smaller than 1
        $start = $start < 1 ? 1 : $start;

        $end = $current + $midSize;
        // end page number can't be higher than total amount of pages
        $end = $end > $totalPagesAmount ? $totalPagesAmount : $end;

        for ($i = $start; $i <= $end; $i++) {
            $this->pages[] = $i;
        }

        // previous page doesn't exist if current page number is smaller than 2
        $this->previous = $current < 2 ? null : $current - 1;

        // next page doesn't exist if current page number is higher or equal to total amount of pages
        $this->next = $current >= $totalPagesAmount ? null : $current + 1;
    }

    /**
     * Returns html list of page links
     *
     * @param string $urlFormat Url containing "%page" string. "%page" is replaced by the page number.
     * @param array $options {
     *  Array of optional settings
     *
     *  @type string $previousText    Text to display inside previous page link.
     *  @type string $previousClass   Class attribute value for previous page list item.
     *  @type string $nextText        Text to display inside next page link.
     *  @type string $nextClass       Class attribute value for next page list item.
     *  @type string $listClass       Class attribute value for list.
     *  @type string $listItemClass   Class attribute value for each list item.
     *  @type string $linkClass       Class attribute value for each link.
     *  @type string $currentClass    Class attribute value for current page list item.
     * }
     * @return string
     */
    public function getHTMLList($urlFormat, $options)
    {
        $previousText = $options['previousText'] ?? 'Previous';
        $previousClass = $options['previousClass'] ?? '';
        $nextText = $options['nextText'] ?? 'Next';
        $nextClass = $options['nextClass'] ?? '';
        $listClass = $options['listClass'] ?? '';
        $listItemClass = $options['listItemClass'] ?? '';
        $linkClass = $options['linkClass'] ?? '';
        $currentClass = $options['currentClass'] ?? '';

        $output = sprintf('<ul class="%s">', $listClass);
      
        if ($this->previous) {
            $url = $this->getPageUrl($this->previous, $urlFormat);

            $output .= sprintf(
                '<li class="%s %s"><a class="%s" href="%s">%s</a></li>',
                $listItemClass,
                $previousClass,
                $linkClass,
                $url,
                $previousText
            );
        }

        foreach ($this->pages as $page) {
            $url = $this->getPageUrl($page, $urlFormat);
            $current = $page === $this->currentPage;

            $output .= sprintf(
                '<li class="%s %s"><a class="%s" href="%s">%d</a></li>',
                $listItemClass,
                $current ? $currentClass : '',
                $linkClass,
                $url,
                $page
            );
        }

        if ($this->next) {
            $url = $this->getPageUrl($this->next, $urlFormat);

            $output .= sprintf(
                '<li class="%s %s"><a class="%s" href="%s">%s</a></li>',
                $listItemClass,
                $nextClass,
                $linkClass,
                $url,
                $nextText
            );
        }

        $output .= '</ul>';

        return $output;
    }

    private function getPageUrl($page, $urlFormat)
    {
        return str_replace('%page', $page, $urlFormat);
    }
}