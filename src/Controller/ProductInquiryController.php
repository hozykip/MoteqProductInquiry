<?php declare(strict_types=1);

namespace MoteqProductInquiry\Controller;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class ProductInquiryController extends StorefrontController
{

    /**
     * @Route("/create-inquiry", name="frontend.moteq.inquiry.create", options={"seo"=false}, methods={"POST","GET"})
     * @param Request $request
     */
    public function createInquiry(Request $request)
    {
        $product_id =$_POST['product_id'];
        $email =$_POST['email'];
        $inquiry =$_POST['inquiry'];

        /** @var EntityRepositoryInterface $productRepository */
        $productRepository = $this->container->get('product.repository');

        /** @var ProductEntity $product */
        $product = $productRepository->search(
            new Criteria([$product_id]),
            \Shopware\Core\Framework\Context::createDefaultContext()
        )->first();

        $versionId = $product->getVersionId();

        if (!$product){
            return new Response("0");
        }

        $productInquiryRepository = $this->container->get('moteq_product_inquiry.repository');

        try {
            $result = $productInquiryRepository->upsert([
                [ 'email'=> $email, 'inquiry' => $inquiry, 'productId' => $product->getId()]
            ], Context::createDefaultContext());
            $mailer = $this->container->get('mailer');
            return new Response("1");
        }catch (\Exception $exception){
            return new Response("0");
        }

    }


}
