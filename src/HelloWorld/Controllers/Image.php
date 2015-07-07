<?php

namespace HelloWorld\Controllers;

use HelloWorld\Models\Reddit as RedditModel;
use Swiftlet\Abstracts\Controller as ControllerAbstract;

class Image extends ControllerAbstract
{
    /**
     * Optional but usually desired 
     * 
     * @var string 
     */
    protected $title = 'Reddit Image';
    
    /**
     * 
     */
    public function show()
    {
        $url = $this->app->getConfig('reddit_pics_url');
        
        // Model instance
        $reddit = new RedditModel;

        // Feed item
        $this->view->redditItem = $reddit->loadXml($url)
                ->getLastItem();
    }
    
}