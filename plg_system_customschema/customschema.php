<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Plugin\CMSPlugin;

class PlgSystemCustomschema extends CMSPlugin
{
    protected $autoloadLanguage = true;

    /**
     * Inject form for adding custom schema to articles and menu items.
     *
     * @param Form $form The form to be altered.
     * @param mixed $data The associated data for the form.
     * @return boolean
     */
    public function onContentPrepareForm(Form $form, $data)
    {
        $name = $form->getName();

        if (!in_array($name, ['com_content.article', 'com_menus.item'])) {
            return true;
        }

        Form::addFormPath(__DIR__ . '/forms');

        if ($name === 'com_content.article') {
            $form->loadFile('content', false);
        } elseif ($name === 'com_menus.item') {
            $form->loadFile('menu', false);
        }

        return true;
    }

    /**
     * Output schema in head if configured so.
     */
    public function onBeforeCompileHead()
    {
        $app = Factory::getApplication();
        if ($app->isClient('administrator')) {
            return;
        }

        if ($this->params->get('schema_position', 'head') !== 'head') {
            return;
        }

        $this->renderSchema();
    }

    /**
     * Output schema in footer if configured so.
     */
    public function onAfterRender()
    {
        $app = Factory::getApplication();
        if ($app->isClient('administrator')) {
            return;
        }

        if ($this->params->get('schema_position', 'head') !== 'footer') {
            return;
        }

        $body = $app->getBody();
        $schemaTag = $this->getSchemaTag();

        if ($schemaTag) {
            $body = str_replace('</body>', $schemaTag . "\n</body>", $body);
            $app->setBody($body);
        }
    }

    /**
     * Helper to render schema tag in head.
     */
    private function renderSchema()
    {
        $schemaTag = $this->getSchemaTag();
        if ($schemaTag) {
            $doc = Factory::getDocument();
            $doc->addCustomTag($schemaTag);
        }
    }

    /**
     * Helper to get the schema tag based on current context.
     *
     * @return string|null
     */
    private function getSchemaTag()
    {
        $app = Factory::getApplication();
        $customSchema = '';

        $input = $app->getInput();
        $option = $input->getCmd('option');
        $view = $input->getCmd('view');

        if ($option === 'com_content' && $view === 'article') {
            $id = $input->getInt('id');
            if ($id) {
                $db = Factory::getDbo();
                $query = $db->getQuery(true)
                    ->select($db->quoteName('attribs'))
                    ->from($db->quoteName('#__content'))
                    ->where($db->quoteName('id') . ' = ' . $id);
                $db->setQuery($query);
                $attribs = $db->loadResult();
                
                if ($attribs) {
                    $registry = new \Joomla\Registry\Registry($attribs);
                    $customSchema = $registry->get('custom_schema', '');
                }
            }
        } else {
            $menu = $app->getMenu()->getActive();
            if ($menu) {
                $customSchema = $menu->getParams()->get('custom_schema', '');
            }
        }

        if (!empty($customSchema)) {
            return '<script type="application/ld+json">' . "\n" . $customSchema . "\n" . '</script>';
        }

        return null;
    }
}
