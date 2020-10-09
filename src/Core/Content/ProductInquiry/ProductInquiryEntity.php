<?php declare(strict_types=1);


namespace MoteqProductInquiry\Core\Content\ProductInquiry;


use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class ProductInquiryEntity extends Entity
{
    use EntityIdTrait;

    protected $email;
    protected $inquiry;
    protected $response;

    /** @var ProductEntity */
    protected $product;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return ProductInquiryEntity
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInquiry()
    {
        return $this->inquiry;
    }

    /**
     * @param mixed $inquiry
     * @return ProductInquiryEntity
     */
    public function setInquiry($inquiry)
    {
        $this->inquiry = $inquiry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     * @return ProductInquiryEntity
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return ProductEntity
     */
    public function getProduct(): ProductEntity
    {
        return $this->product;
    }

    /**
     * @param ProductEntity $product
     * @return ProductInquiryEntity
     */
    public function setProduct(ProductEntity $product): ProductInquiryEntity
    {
        $this->product = $product;
        return $this;
    }


}
