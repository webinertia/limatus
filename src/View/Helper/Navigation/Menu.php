<?php

declare(strict_types=1);

namespace Limatus\View\Helper\Navigation;

use Laminas\Navigation\Page\AbstractPage;
use Laminas\View\Helper\EscapeHtml;
use Laminas\View\Helper\Navigation\Menu as BaseMenu;

use function is_string;

class Menu extends BaseMenu
{
    /**
     * CSS class to use for the active li element.
     *
     * @var string
     */
    protected $liActiveClass = 'active';

    protected $aActiveClass = 'active';

    /**
     * Returns an HTML string containing an 'a' element for the given page if
     * the page's href is not empty, and a 'span' element if it is empty.
     *
     * Overrides {@link AbstractHelper::htmlify()}.
     *
     * @param  AbstractPage $page               page to generate HTML for
     * @param  bool         $escapeLabel        Whether or not to escape the label
     * @param  bool         $addClassToListItem Whether or not to add the page class to the list item
     * @return string
     */
    public function htmlify(AbstractPage $page, $escapeLabel = true, $addClassToListItem = false)
    {
        // get attribs for element
        $attribs = [
            'id'    => $page->getId(),
            'title' => $this->translate($page->getTitle(), $page->getTextDomain()),
        ];

        if ($addClassToListItem === false) {
            $attribs['class'] = $page->getClass();
        }

        // does page have a href?
        $href = $page->getHref();
        if ($href) {
            $element           = 'a';
            $attribs['href']   = $href;
            $attribs['target'] = $page->getTarget();
        } else {
            $element = 'span';
        }

        if ($page->isActive()) {
            $attribs['aria-current'] = 'page';
            // bootstrap
            if (isset($attribs['class']) && is_string($attribs['class'])) {
                // class was passed from config
                $attribs['class'] = $attribs['class'] . ' ' . $this->aActiveClass;
            } else {
                $attribs['class'] = $this->aActiveClass;
            }
        }

        $html  = '<' . $element . $this->htmlAttribs($attribs) . '>';
        $label = $this->translate($page->getLabel(), $page->getTextDomain());

        if ($escapeLabel === true) {
            /** @var EscapeHtml $escaper */
            $escaper = $this->view->plugin('escapeHtml');
            $html   .= $escaper($label);
        } else {
            $html .= $label;
        }

        $html .= '</' . $element . '>';
        return $html;
    }
}
