<?php declare(strict_types=1);

namespace Lmc\Matej\RequestBuilder;

use Lmc\Matej\Http\RequestManager;
use Lmc\Matej\Model\Command\Sorting;
use Lmc\Matej\Model\Command\UserRecommendation;

/**
 * Factory to create concrete RequestBuilder which helps you to create request for each Matej API
 */
class RequestBuilderFactory
{
    /** @var RequestManager */
    private $requestManager;

    public function __construct(RequestManager $requestManager)
    {
        $this->requestManager = $requestManager;
    }

    public function getItemProperties(): ItemPropertiesGetRequestBuilder
    {
        return $this->createConfiguredBuilder(ItemPropertiesGetRequestBuilder::class);
    }

    /**
     * Define new properties into the database. Those properties will be created and subsequently accepted by Matej.
     */
    public function setupItemProperties(): ItemPropertiesSetupRequestBuilder
    {
        return $this->createConfiguredBuilder(ItemPropertiesSetupRequestBuilder::class);
    }

    /**
     * Added item properties will be IRREVERSIBLY removed from all items in the database and the item property will
     * from now be rejected by Matej.
     */
    public function deleteItemProperties(): ItemPropertiesSetupRequestBuilder
    {
        return $this->createConfiguredBuilder(ItemPropertiesSetupRequestBuilder::class, $shouldDelete = true);
    }

    public function events(): EventsRequestBuilder
    {
        return $this->createConfiguredBuilder(EventsRequestBuilder::class);
    }

    public function campaign(): CampaignRequestBuilder
    {
        return $this->createConfiguredBuilder(CampaignRequestBuilder::class);
    }

    public function sorting(Sorting $sorting): SortingRequestBuilder
    {
        return $this->createConfiguredBuilder(SortingRequestBuilder::class, $sorting);
    }

    public function recommendation(UserRecommendation $recommendation): RecommendationRequestBuilder
    {
        return $this->createConfiguredBuilder(RecommendationRequestBuilder::class, $recommendation);
    }

    public function forget(): ForgetRequestBuilder
    {
        return $this->createConfiguredBuilder(ForgetRequestBuilder::class);
    }

    public function resetDatabase(): ResetDatabaseRequestBuilder
    {
        return $this->createConfiguredBuilder(ResetDatabaseRequestBuilder::class);
    }

    private function createConfiguredBuilder(string $builderClass, ...$args)
    {
        /** @var AbstractRequestBuilder $requestBuilder */
        $requestBuilder = new $builderClass(...$args);

        $requestBuilder->setRequestManager($this->requestManager);

        return $requestBuilder;
    }
}
