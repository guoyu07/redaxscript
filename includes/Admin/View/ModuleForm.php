<?php
namespace Redaxscript\Admin\View;

use Redaxscript\Admin\Html\Form as AdminForm;
use Redaxscript\Db;
use Redaxscript\Directory;
use Redaxscript\Html;
use Redaxscript\Module;
use Redaxscript\Template;

/**
 * children class to create the module form
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Admin
 * @author Henry Ruhs
 */

class ModuleForm extends ViewAbstract implements ViewInterface
{
	/**
	 * render the view
	 *
	 * @since 3.0.0
	 *
	 * @param integer $moduleId identifier of the module
	 *
	 * @return string
	 */

	public function render($moduleId = null)
	{
		$output = Module\Hook::trigger('adminModuleFormStart');
		$module = Db::forTablePrefix('modules')->whereIdIs($moduleId)->findOne();

		/* html elements */

		$titleElement = new Html\Element();
		$titleElement->init('h2',
		[
			'class' => 'rs-admin-title-content',
		]);
		$titleElement->text($module->name);
		$linkElement = new Html\Element();
		$linkElement->init('a');
		$itemElement = new Html\Element();
		$itemElement->init('li');
		$listElement = new Html\Element();
		$listElement->init('ul',
		[
			'class' => 'rs-admin-js-list-tab rs-admin-list-tab'
		]);
		$formElement = new AdminForm($this->_registry, $this->_language);
		$formElement->init(
		[
			'form' =>
			[
				'action' => $this->_registry->get('parameterRoute') . ($module->id ? 'admin/process/modules/' . $module->id : 'admin/process/modules'),
				'class' => 'rs-admin-js-tab rs-admin-js-validate-form rs-admin-component-tab rs-admin-form-default rs-admin-fn-clearfix'
			],
			'link' =>
			[
				'cancel' =>
				[
					'href' => $this->_registry->get('modulesEdit') && $this->_registry->get('modulesUninstall') ? $this->_registry->get('parameterRoute') . 'admin/view/modules' : $this->_registry->get('parameterRoute') . 'admin'
				],
				'uninstall' =>
				[
					'href' => $module->alias ? $this->_registry->get('parameterRoute') . 'admin/uninstall/modules/' . $module->alias . '/' . $this->_registry->get('token') : null
				]
			]
		]);

		/* docs directory */

		$docsDirectory = new Directory();
		$docsDirectory->init('modules/' . $module->alias . '/docs');
		$docsDirectoryArray = $docsDirectory->getArray();

		/* collect item output */

		$tabCounter = 1;
		$tabRoute = $this->_registry->get('parameterRoute') . $this->_registry->get('fullRoute');
		$outputItem = $itemElement
			->copy()
			->addClass('rs-admin-js-item-active rs-admin-item-active')
			->html($linkElement
				->copy()
				->attr('href', $tabRoute . '#tab-' . $tabCounter++)
				->text($this->_language->get('module'))
			);

		/* process directory */

		foreach ($docsDirectoryArray as $value)
		{
			$outputItem .= $itemElement
				->copy()
				->html($linkElement
					->copy()
					->attr('href', $tabRoute . '#tab-' . $tabCounter++)
					->text(pathinfo($value, PATHINFO_FILENAME))
				);
		}

		/* collect item output */

		$outputItem .= $itemElement
			->copy()
			->html($linkElement
				->copy()
				->attr('href', $tabRoute . '#tab-' . $tabCounter++)
				->text($this->_language->get('customize'))
			);
		$listElement->append($outputItem);

		/* create the form */

		$tabCounter = 1;
		$formElement
			->append($listElement)
			->append('<div class="rs-admin-js-box-tab rs-admin-box-tab rs-admin-box-tab">')

			/* first tab */

			->append('<fieldset id="tab-' . $tabCounter++ . '" class="rs-admin-js-set-tab rs-admin-js-set-active rs-admin-set-tab rs-admin-set-active"><ul><li>')
			->label($this->_language->get('name'),
			[
				'for' => 'name'
			])
			->text(
			[
				'autofocus' => 'autofocus',
				'id' => 'name',
				'name' => 'name',
				'required' => 'required',
				'value' => $module->name
			])
			->append('</li><li>')
			->label($this->_language->get('description'),
			[
				'for' => 'description'
			])
			->textarea(
			[
				'class' => 'rs-admin-js-auto-resize rs-admin-field-textarea rs-admin-field-small',
				'id' => 'description',
				'name' => 'description',
				'rows' => 1,
				'value' => $module->description
			])
			->append('</li></ul></fieldset>');

			/* second tab */

			if ($docsDirectoryArray)
			{
				/* process directory */

				foreach ($docsDirectoryArray as $value)
				{
					$formElement
						->append('<fieldset id="tab-' . $tabCounter++ . '" class="rs-admin-js-set-tab rs-admin-set-tab">')
						->append(Template\Tag::partial('modules/' . $module->alias . '/docs/' . $value))
						->append('</fieldset>');
				}
			}

			/* last tab */

		$formElement
			->append('<fieldset id="tab-' . $tabCounter++ . '" class="rs-admin-js-set-tab rs-admin-set-tab"><ul><li>')
			->label($this->_language->get('status'),
			[
				'for' => 'status'
			])
			->select(Helper\Option::getToggleArray(),
			[
				'id' => 'status',
				'name' => 'status',
				'value' => intval($module->status)
			])
			->append('</li>');
		if ($this->_registry->get('groupsEdit'))
		{
			$formElement
				->append('<li>')
				->label($this->_language->get('access'),
				[
					'for' => 'access'
				])
				->select(Helper\Option::getAccessArray('groups'),
				[
					'id' => 'access',
					'name' => 'access[]',
					'multiple' => 'multiple',
					'size' => count(Helper\Option::getAccessArray('groups')),
					'value' => $module->access
				])
				->append('</li>');
		}
		$formElement
			->append('</ul></fieldset></div>')
			->token()
			->cancel();
		if ($this->_registry->get('modulesUninstall'))
		{
			$formElement->uninstall();
		}
		if ($this->_registry->get('modulesEdit'))
		{
			$formElement->save();
		}

		/* collect output */

		$output .= $titleElement . $formElement;
		$output .= Module\Hook::trigger('adminModuleFormEnd');
		return $output;
	}
}
