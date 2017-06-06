<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Settings;

use SymEdit\Bundle\SettingsBundle\Schema\SchemaInterface;
use SymEdit\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class SeoSettingsSchema implements SchemaInterface
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('head_extra', TextareaType::class, [
                'label' => 'symedit.settings.seo.head_extra',
                'required' => false,
                'attr' => ['rows' => 5],
            ])
            ->add('body_extra', TextareaType::class, [
                'label' => 'symedit.settings.seo.body_extra',
                'required' => false,
                'attr' => ['rows' => 5],
            ])
            ->add('business_type', ChoiceType::class, [
                'label' => 'symedit.settings.seo.business_type',
                'choice_translation_domain' => false,
                'choices' => [
                    'LocalBusiness' => 'Local Business (Default)',
                    'AnimalShelter' => 'Animal Shelter',
                    'AutomotiveBusiness' => 'Automotive Business',
                    'ChildCare' => 'Child Care',
                    'DryCleaningOrLaundry' => 'Dry Cleaning / Laundry',
                    'EmergencyService' => 'Emergency Service',
                    'EmploymentAgency' => 'Employment Agency',
                    'EntertainmentBusiness' => 'Entertainment',
                    'FinancialService' => 'Financial Service',
                    'FoodEstablishment' => 'Food Establishment',
                    'Bakery' => 'Bakery',
                    'BarOrPub' => 'Bar / Pub',
                    'Brewery' => 'Brewery',
                    'CafeOrCoffeeShop' => 'Cafe / Coffee Shop',
                    'FastFoodRestaurant' => 'Fast Food Restaurant',
                    'IceCreamShop' => 'Ice Cream Shop',
                    'Restaurant' => 'Restaurant',
                    'Winery' => 'Winery',
                    'GovernmentOffice' => 'Government Office',
                    'HealthAndBeautyBusiness' => 'Health and Beauty',
                    'HomeAndConstructionBusiness' => 'Home and Construction',
                    'InternetCafe' => 'Internet Cafe',
                    'Library' => 'Library',
                    'LodgingBusiness' => 'Lodging Business',
                    'MedicalOrganization' => 'Medical Organization',
                    'ProfessionalService' => 'Professional Service',
                    'RadioStation' => 'Radio Station',
                    'RealEstateAgent' => 'RealEstateAgent',
                    'RecyclingCenter' => 'Recycling Center',
                    'SelfStorage' => 'Self Storage',
                    'ShoppingCenter' => 'Shopping Center',
                    'SportsActivityLocation' => 'Sports Activity Location',
                    'Store' => 'Store',
                    'AutoPartsStore' => 'Auto Parts',
                    'BikeStore' => 'Bike Store',
                    'BookStore' => 'Book Store',
                    'ClothingStore' => 'Clothing Store',
                    'ComputerStore' => 'Computer Store',
                    'ConvenienceStore' => 'Convenience Store',
                    'DepartmentStore' => 'Department Store',
                    'ElectronicsStore' => 'Electronics',
                    'Florist' => 'Florist',
                    'FurnitureStore' => 'Furniture Store',
                    'GardenStore' => 'Garden Store',
                    'GroceryStore' => 'Grocery Store',
                    'HardwareStore' => 'Hardware Store',
                    'HobbyShop' => 'Hobby Shop',
                    'HomeGoodsStore' => 'Home Goods',
                    'JewelryStore' => 'Jewelry Store',
                    'LiquorStore' => 'Liquor Store',
                    'MensClothingStore' => 'Mens Clothing',
                    'MobilePhoneStore' => 'Mobile Phone Store',
                    'MovieRentalStore' => 'Movie Rental',
                    'MusicStore' => 'Music Store',
                    'OfficeEquipmentStore' => 'Office Equipment',
                    'OutletStore' => 'Outlet Store',
                    'PawnShop' => 'Pawn Shop',
                    'PetStore' => 'Pet Store',
                    'ShoeStore' => 'Shoe Store',
                    'SportingGoodsStore' => 'Sporting Goods',
                    'TireShop' => 'Tire Shop',
                    'ToyStore' => 'Toy Store',
                    'WholesaleStore' => 'Wholesale Store',
                    'TelevisionStation' => 'Television Station',
                    'TouristInformationCenter' => 'Tourist Information Center',
                    'TravelAgency' => 'Travel Agency',
                ],
            ])
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults([
                'head_extra' => null,
                'body_extra' => null,
                'business_type' => 'LocalBusiness',
            ])
        ;
    }
}
