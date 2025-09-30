<?php

namespace App\Traits;

use Exception;

trait MediaModelConnectorTrait
{

    public function setVendorImages($vendor)
    {

        $vendorName = $vendor->name;
        $vendorName = str_replace(' ', '', $vendorName);

        try {
            $fileName = strtolower($vendorName) . ".png";
            $photo = public_path('images/vendors/' . $fileName);
            $vendor->clearMediaCollection("logo");
            $vendor->addMedia($photo)
                ->preservingOriginal()
                ->toMediaCollection("logo");
        } catch (Exception $ex) {
            logger("error syncing vendor logo", [$ex]);
        }

        //
        try {
            $fileName = strtolower($vendorName) . "_feature_image.png";
            $photo = public_path('images/vendors/' . $fileName);
            $vendor->clearMediaCollection("feature_image");
            $vendor->addMedia($photo)
                ->preservingOriginal()
                ->toMediaCollection("feature_image");
        } catch (Exception $ex) {
            logger("error syncing vendor feature_image", [$ex]);
        }

        return $vendor;
    }

    public function setProductImages($product)
    {
        try {
            $productName = $product->name;
            $productName = str_replace(' ', '', $productName);
            $fileName = strtolower($productName) . ".png";
            $photo = public_path('images/products/' . $fileName);
            // logger("File Name", [
            //     "product name" => $product->name,
            //     "photo" => $photo,
            // ]);
            $product->clearMediaCollection();
            $product->addMedia($photo)
                ->preservingOriginal()
                ->toMediaCollection();
        } catch (Exception $ex) {
            logger("error syncing product image", [$ex]);
        }
        return $product;
    }
}
