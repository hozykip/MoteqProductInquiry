<?php


namespace MoteqProductInquiry\Subscriber;


use MoteqProductInquiry\Core\Content\ProductInquiry\ProductInquiryDefinition;
use MoteqProductInquiry\Core\Content\ProductInquiry\ProductInquiryEntity;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenContainerEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductInquiryAnsweredSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $moteqInquiryRepoEntityRepository;
    private $productEntityRepository;
    public function __construct(\Swift_Mailer $mailer, EntityRepositoryInterface $moteqInquiryRepoEntityRepository, EntityRepositoryInterface $productEntityRepository)
    {
        $this->mailer = $mailer;
        $this->moteqInquiryRepoEntityRepository = $moteqInquiryRepoEntityRepository;
        $this->productEntityRepository = $productEntityRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            EntityWrittenContainerEvent::class => 'onEntityWrittenContainer'
        ];
    }


    public function onEntityWrittenContainer(EntityWrittenContainerEvent $event)
    {

        $entityWrittenEvent = $event->getEventByEntityName(ProductInquiryDefinition::ENTITY_NAME) ?? "None";

        if ($entityWrittenEvent != "None"){
            $writeResults = $entityWrittenEvent->getWriteResults();

            foreach ($writeResults as $entityWriteResult){
                $payload = $entityWriteResult->getPayload();

                if ($payload != null && is_array($payload) && array_key_exists('response',$payload) && !empty($payload['response'])){
                    $response = $payload['response'];

                    $inquiryId = $payload['id'];

                    /** @var ProductInquiryEntity $productInquiry */
                    $productInquiry = $this->moteqInquiryRepoEntityRepository->search(
                        new Criteria([$inquiryId]),
                        Context::createDefaultContext()
                    )->first();

                    $productId = $productInquiry->productId;

                    /** @var ProductEntity $product */
                    $product = $this->productEntityRepository->search(
                        new Criteria([$productId]),
                        Context::createDefaultContext()
                    )->first();

                    $email = $productInquiry->getEmail();
                    $inquiry = $productInquiry->getInquiry();

                    $message = sprintf("<p>You had inquired about <strong>%s</strong>: </p>", $product->getName());
                    $message .= sprintf("<p>%s</p>", $inquiry);
                    $message .= sprintf("<p>Here is our response: </p>");
                    $message .= sprintf("<p><strong>%s</strong> </p>", $response);
                    $message .= sprintf("<br><p>Regards, </p>");

                    $this->sendMail($message, $email);


                }
            }
        }

    }


    public function sendMail($message, $to)
    {
        $message = (new \Swift_Message('Product Inquiry'))
            ->setFrom('inquiry@shopware.com')
            ->setTo($to)
            ->setBody(
                $message,
                'text/html'
            );

        return $this->mailer->send($message);
    }
}
