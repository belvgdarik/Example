<?php

namespace Example\Vendor\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\State;
use Magento\Catalog\Api\ProductRepositoryInterface;

class AddImageToProduct extends Command
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var State
     */
    private $state;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        State $state,
        $name = null
    )
    {
        $this->productRepository = $productRepository;
        $this->state = $state;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('example:add-image');
        $this->setDescription('this command add an image to the product');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // add an image
        $this->state->setAreaCode('adminhtml');
        $product = $this->productRepository->getById(1);
        $imagePath = 'image.png'; // put image at pub/media directory
        $product->addImageToMediaGallery($imagePath, ['image', 'small_image', 'thumbnail'], false, false);
        $product->save();
    }
}