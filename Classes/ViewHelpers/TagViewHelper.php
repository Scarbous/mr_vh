<?php

namespace Scarbous\MrVh\ViewHelpers;


class TagViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{
    /**
     * Initialize ViewHelper arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('name', 'string', 'Tag name', true);
        $this->registerTagAttribute('class', 'string', 'CSS class(es) for this element');
        $this->registerTagAttribute('id', 'string', 'Unique (in this file) identifier for this HTML element.');
        $this->registerTagAttribute('style', 'string', 'Individual CSS styles for this element');
        $this->registerArgument('condition', 'boolean', 'Condition expression conforming to Fluid boolean rules', false,
            false);
    }

    /**
     * Render method
     *
     * @return string
     */
    public function render()
    {
        $content = $this->renderChildren();
        if (static::evaluateCondition($this->arguments)) {
            $this->tag->setContent($content);
            $classes = [];
            foreach (explode(' ', $this->arguments['class']) as $class) {
                if (trim($class)) {
                    $classes[] = $class;
                }
            }
            if ($classes) {
                $this->tag->addAttribute('class', implode(' ', $classes));
            }

            $styles = [];
            foreach (explode(';', $this->arguments['style']) as $style) {
                if (trim($style)) {
                    $styles[] = $style;
                }
            }
            if ($styles) {
                $this->tag->addAttribute('style', implode('; ', $styles));
            }
            if ($id = trim($this->arguments['id'])) {
                $this->tag->addAttribute('id', $id);
            }
            $this->tag->setTagName($this->arguments['name']);
            return $this->tag->render();
        } else {
            return $content;
        }
    }

    /**
     * @param array|NULL $arguments
     * @return boolean
     * @api
     */
    protected static function evaluateCondition($arguments = null)
    {
        return (boolean)$arguments['condition'];
        die();
    }
}