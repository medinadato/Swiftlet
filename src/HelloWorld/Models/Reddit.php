<?php

namespace HelloWorld\Models;

use \Swiftlet\Abstracts\Model as ModelAbstract;

/**
 * Example model
 */
class Reddit extends ModelAbstract
{

    /**
     *
     * @var SimpleXmlElement 
     */
    protected $xmlFeed;
    
    /**
     * 
     */
    public function __construct()
    {
        $url = $this->app->getConfig('reddit_pics_url');
        
        $this->loadXml($url);
    }
    
    /**
     * Load xml feed
     * 
     * @param string $url
     * @return boolean
     */
    public function loadXml($url)
    {
        $this->xmlFeed = simplexml_load_file($url);
        
        return true;
    }
    
    /**
     * 
     * @param SimpleXmlElement $item
     * @param string $child
     * @return SimpleXmlElement
     */
    public function getItemChild($item, $child)
    {
        $ns = $item->getNamespaces(true);
        
        return $item->children($ns[$child]); 
    }

    /**
     * 
     * @return array
     */
    public function getLastItem()
    {
        $last_item = $this->xmlFeed->xpath("/rss/channel/item[last()]");

        $child = $this->getItemChild($last_item[0], 'media');
        
        $last_item[0]->addChild('img_url', $child->thumbnail->attributes()->url);
        
        return (array) $last_item[0];
    }

}
