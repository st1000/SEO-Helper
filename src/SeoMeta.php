<?php namespace Arcanedev\SeoHelper;

use Arcanedev\SeoHelper\Entities\Description;
use Arcanedev\SeoHelper\Entities\Keywords;
use Arcanedev\SeoHelper\Entities\MiscTags;
use Arcanedev\SeoHelper\Entities\Title;

/**
 * Class     SeoMeta
 *
 * @package  Arcanedev\SeoHelper
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SeoMeta implements Contracts\SeoMeta
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Title instance.
     *
     * @var Title
     */
    protected $title;

    /**
     * Description instance.
     *
     * @var Description
     */
    protected $description;

    /**
     * Description instance.
     *
     * @var Keywords
     */
    protected $keywords;

    /**
     * MiscTags instance.
     *
     * @var MiscTags
     */
    protected $misc;

    /**
     * Current URL.
     *
     * @var string
     */
    protected $currentUrl = '';

    /**
     * SEO Helper configs.
     *
     * @var array
     */
    private $configs = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make SeoMeta instance.
     *
     * @param  array  $configs
     */
    public function __construct(array $configs)
    {
        $this->configs  = $configs;
        $this->init();
    }

    /**
     * Start the engine.
     */
    private function init()
    {
        $this->title       = new Title($this->getConfig('title', []));
        $this->description = new Description($this->getConfig('description', []));
        $this->keywords    = new Keywords($this->getConfig('keywords', []));
        $this->misc        = new MiscTags($this->getConfig('misc', []));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title->getTitle();
    }

    /**
     * Set the title.
     *
     * @param  string  $title
     * @param  string  $siteName
     * @param  string  $separator
     *
     * @return self
     */
    public function setTitle($title, $siteName = null, $separator = null)
    {
        $this->title->setTitle($title);

        if ( ! is_null($siteName)) {
            $this->title->setSiteName($siteName);
        }

        if ( ! is_null($separator)) {
            $this->title->setSeparator($separator);
        }

        return $this;
    }

    /**
     * Get the description content.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description->getContent();
    }

    /**
     * Set the description content.
     *
     * @param  string  $content
     *
     * @return self
     */
    public function setDescription($content)
    {
        $this->description->setContent($content);

        return $this;
    }

    /**
     * Get the keywords content.
     *
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords->getContent();
    }

    /**
     * Set the keywords content.
     *
     * @param  array|string  $content
     *
     * @return self
     */
    public function setKeywords($content)
    {
        $this->keywords->setContent($content);

        return $this;
    }

    /**
     * Add a keyword.
     *
     * @param  string  $keyword
     *
     * @return self
     */
    public function addKeyword($keyword)
    {
        $this->keywords->add($keyword);

        return $this;
    }

    /**
     * Set the current URL.
     *
     * @param  string  $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->currentUrl = $url;
        $this->misc->setUrl($url);

        return $this;
    }

    /**
     * Add a meta tag.
     *
     * @param  string  $name
     * @param  string  $content
     *
     * @return self
     */
    public function addMeta($name, $content)
    {
        $this->misc->addMeta($name, $content);

        return $this;
    }

    /**
     * Add many meta tags.
     *
     * @param  array  $metas
     *
     * @return self
     */
    public function addMetas(array $metas)
    {
        $this->misc->addMetas($metas);

        return $this;
    }

    /**
     * Remove a meta from the meta collection by key.
     *
     * @param  string|array  $names
     *
     * @return self
     */
    public function removeMeta($names)
    {
        $this->misc->removeMeta($names);

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render all seo tags.
     *
     * @return string
     */
    public function render()
    {
        return implode(PHP_EOL, array_filter([
            $this->renderTitle(),
            $this->renderDescription(),
            $this->renderKeywords(),
            $this->renderMisc(),
        ]));
    }

    /**
     * Render title tag.
     *
     * @return string
     */
    public function renderTitle()
    {
        return $this->title->render();
    }

    /**
     * Render description tag.
     *
     * @return string
     */
    public function renderDescription()
    {
        return $this->description->render();
    }

    /**
     * Render keywords tag.
     *
     * @return string
     */
    public function renderKeywords()
    {
        return $this->keywords->render();
    }

    /**
     * Render Miscellaneous tags.
     *
     * @return string
     */
    public function renderMisc()
    {
        return $this->misc->render();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get config.
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    private function getConfig($key, $default = null)
    {
        return array_get($this->configs, $key, $default);
    }
}
