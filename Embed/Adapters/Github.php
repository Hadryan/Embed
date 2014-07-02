<?php
/**
 * Adapter to get the embed code from gist.github.com
 */
namespace Embed\Adapters;

use Embed\Request;
use Embed\Providers\Provider;

class Github extends Webpage implements AdapterInterface
{
    /**
     * {@inheritDoc}
     */
    public static function check(Request $request)
    {
        return $request->match(array(
            'https://gist.github.com/*/*'
        ));
    }


    /**
     * {@inheritDoc}
     */
    protected function initProviders(Request $request)
    {
        parent::initProviders($request);

        $this->api = new Provider();
        $api = new Request($request->getUrl().'.json');

        if (($json = $api->getJsonContent())) {
            $this->api->set($json);
        }
    }


    /**
     * {@inheritDoc}
     */
    public function getCode()
    {
        if (($code = $this->api->get('div')) && ($stylesheet = $this->api->get('stylesheet'))) {
            return  '<link href="'.$stylesheet.'" rel="stylesheet">'.$code;
        }
    }


    /**
     * {@inheritDoc}
     */
    public function getProviderName()
    {
        return 'Gist';
    }


    /**
     * {@inheritDoc}
     */
    public function getProviderUrl()
    {
        return 'https://gist.github.com';
    }
}
