<?php
namespace Oro\Bundle\FlexibleEntityBundle\Model;

use Oro\Bundle\FlexibleEntityBundle\AttributeType\AttributeTypeInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Abstract attribute type
 *
 * @author    Nicolas Dupont <nicolas@akeneo.com>
 * @copyright 2012 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/MIT MIT
 *
 */
abstract class AbstractAttributeType implements AttributeTypeInterface
{
    /**
     * Available backend storage, the flexible doctrine mapped field
     * 
     * @var string
     */
    const BACKEND_STORAGE_ATTRIBUTE_VALUE = 'values';

    /**
     * Available backend types, the doctrine mapped field in value class
     * 
     * @var string
     */
    const BACKEND_TYPE_DATE     = 'date';
    const BACKEND_TYPE_DATETIME = 'datetime';
    const BACKEND_TYPE_DECIMAL  = 'decimal';
    const BACKEND_TYPE_INTEGER  = 'integer';
    const BACKEND_TYPE_OPTIONS  = 'options';
    const BACKEND_TYPE_OPTION   = 'option';
    const BACKEND_TYPE_TEXT     = 'text';
    const BACKEND_TYPE_VARCHAR  = 'varchar';
    const BACKEND_TYPE_MEDIA    = 'media';
    const BACKEND_TYPE_METRIC   = 'metric';
    const BACKEND_TYPE_PRICE    = 'price';

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Attribute type name
     *
     * @var string
     */
    protected $name;

    /**
     * Attribute type options
     *
     * @var array
     */
    protected $options;

    /**
     * Field backend type, "varchar" by default, the doctrine mapping field, getter / setter to use for binding
     *
     * @var string
     */
    protected $backendType = self::BACKEND_TYPE_VARCHAR;

    /**
     * Form type alias, "text" by default
     *
     * @var string
     */
    protected $formType = 'text';

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Initialize
     *
     * @param string $name    the name
     * @param array  $options the options
     */
    public function initialize($name, $options = array())
    {
        $this->name = $name;
        $this->options = $options;
    }
    
    /**
     * Get attribute type name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get attribute type options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get backend type
     *
     * @return string
     */
    public function getBackendType()
    {
        return $this->backendType;
    }

    /**
     * Get form type (alias)
     *
     * @return string
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * Get form type options
     *
     * @param AbstractAttribute $attribute
     *
     * @return array
     */
    public function prepareFormOptions(AbstractAttribute $attribute)
    {
        $options = array(
            'label'    => $attribute->getCode(),
            'required' => $attribute->getRequired()
        );

        return $options;
    }
}
