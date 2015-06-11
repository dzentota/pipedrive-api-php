<?php namespace Benhawker\Pipedrive\Library;

use Benhawker\Pipedrive\Exceptions\PipedriveMissingFieldError;

/**
 * Pipedrive Products Methods
 *
 * Products are the goods or services you are dealing with.
 * Each product can have N different price points - first, each Product can
 * have a price in N different currencies, and secondly, each Product can
 * have N variations of itself, each having N prices different currencies.
 * Note that only one price per variation per currency is supported.
 * Products can be instantiated to Deals. In the context of instatiation,
 * a custom price, quantity, duration and discount can be applied.
 */
class Products
{
    /**
     * Hold the pipedrive cURL session
     * @var \Benhawker\Pipedrive\Library\Curl Curl Object
     */
    protected $curl;

    /**
     * Initialise the object load master class
     */
    public function __construct(\Benhawker\Pipedrive\Pipedrive $master)
    {
        //associate curl class
        $this->curl = $master->curl();
    }

    /**
     * Returns a product / products
     *
     * @param  string $name pipedrive prodeuct name
     * @return array  returns detials of a product
     */
    public function getByName($name)
    {
        $params = array('term' => $name);
        return $this->curl->get('products/find', $params);
    }
    
    /**
     * Updates a product
     *
     * @param  int   $productId pipedrives product Id
     * @param  array $data     new details of product
     * @return array returns detials of a product
     */
    public function update($productId, array $data = array())
    {
        return $this->curl->put('products/' . $productId, $data);
    }

    /**
     * Adds a product
     *
     * @param  array $data products details
     * @return array returns details of a product
     * @throws PipedriveMissingFieldError
     */
    public function add(array $data)
    {
        //if there is no name set throw error as it is a required field
        if (!isset($data['name'])) {
            throw new PipedriveMissingFieldError('You must include a "name" field when inserting a person');
        }

        return $this->curl->post('products', $data);
    }

    /**
     * Deletes a product
     *
     * @param  int   $productId pipedrives product Id
     * @return array returns details of a product
     */
    public function delete($productId)
    {
        return $this->curl->delete('products/' . $productId);
    }
}
