<?php

namespace Theme\Helpers;


use Illuminate\Contracts\Support\Arrayable;

class GoogleMapsObject implements Arrayable
{
    protected string $title;
    protected string $mapsStyling = 'default';

    protected string $mapsHeight;

    protected string $mapsType = 'roadmap';

    protected int $mapsZoomLevel;
    protected bool $showMapsTypeControl = false;
    protected bool $showFullscreenControl = false;
    protected bool $showZoomControl = false;
    protected bool $showStreetViewControl = false;

    protected bool $allowScrollwheel = false;

    protected bool $autoOpenInfoWindow = false;

    protected string $customMarker = '';

    protected string $latitude = '';

    protected string $longitude = '';
    protected string $mapsCity = '';
    protected string $mapsStreet = '';

    protected string $mapsHouseNumber;

    protected string $mapsHouseAddition = '';

    protected string $mapsZipCode = '';

    protected string $mapsPhoneNumber = '';

    protected string $mapsEmail = '';
    public function __construct(array $data)
    {
        $this->setTitle($data['title'] ?? '');

        if(!empty($data['maps_styling'])) {
            $this->setMapsStyling( $data['maps_styling']);
        }

        if(!empty($data['maps_height'])) {
            $this->setMapsHeight( $data['maps_height']);
        }

        if(!empty($data['maps_type'])) {
            $this->setMapsType( $data['maps_type']);
        }

        if(!empty($data['zoom_level'])) {
            $this->setMapsZoomLevel( $data['zoom_level']);
        }

        if(!empty($data['maps_city'])) {
            $this->setMapsCity($data['maps_city']);

        }

        if(!empty($data['maps_street'])) {
            $this->setMapsStreet($data['maps_street']);
        }

        if(!empty($data['maps_house_number'])) {
            $this->setMapsHouseNumber($data['maps_house_number']);
        }

        if(!empty($data['latitude'])) {
            $this->setLatitude($data['latitude']);
        }

        if(!empty($data['longitude'])) {
            $this->setLongitude($data['longitude']);
        }

        if(!empty($data['maps_house_addition'])) {
            $this->setMapsHouseAddition($data['maps_house_addition']);
        }

        if(!empty($data['maps_zip_code'])) {
            $this->setMapsZipCode($data['maps_zip_code']);
        }

        if(!empty($data['maps_phone_number'])) {
            $this->setMapsPhoneNumber($data['maps_phone_number']);
        }

        if(!empty($data['maps_email'])) {
            $this->setMapsEmail($data['maps_email']);
        }

        if(!empty($data['show_map_type_control'])){
            $this->setShowMapsTypeControl($this->wordPressBooleanToBoolean($data['show_map_type_control']));
        }

        if(!empty($data['show_fullscreen_control'])){
            $this->setShowFullscreenControl($this->wordPressBooleanToBoolean($data['show_fullscreen_control']));
        }

        if(!empty($data['show_zoom_control'])){
            $this->setShowZoomControl($this->wordPressBooleanToBoolean($data['show_zoom_control']));
        }

        if(!empty($data['show_street_view_control'])){
            $this->setShowStreetViewControl($this->wordPressBooleanToBoolean($data['show_street_view_control']));
        }

        if(!empty($data['allow_scroll_wheel_zoom'])){
            $this->setAllowScrollwheel($this->wordPressBooleanToBoolean($data['allow_scroll_wheel_zoom']));
        }

        if(!empty($data['auto_open_info_window'])){
            $this->setAutoOpenInfoWindow($this->wordPressBooleanToBoolean($data['auto_open_info_window']));
        }

        if(!empty($data['custom_marker'])) {
            $this->setMapsHeight( $data['custom_marker']);
        }
    }

    private function wordPressBooleanToBoolean(string $boolean): bool
    {
        return !($boolean === '0');
    }

    public function render(string $view = 'components.google_maps', array $args = []): string
    {
        return view($view, array_merge($this->toArray(), $args))->render();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getMapsStyling(): string
    {
        return $this->mapsStyling;
    }

    public function setMapsStyling(string $mapsStyling): void
    {
        $this->mapsStyling = $mapsStyling;
    }

    public function getMapsHeight(): string
    {
        return $this->mapsHeight;
    }

    public function setMapsHeight(string $mapsHeight): void
    {
        $this->mapsHeight = $mapsHeight;
    }

    public function getMapsType(): string
    {
        return $this->mapsType;
    }

    public function setMapsType(string $mapsType): void
    {
        $this->mapsType = $mapsType;
    }

    public function getMapsZoomLevel(): int
    {
        return $this->mapsZoomLevel;
    }

    public function setMapsZoomLevel(int $mapsZoomLevel): void
    {
        $this->mapsZoomLevel = $mapsZoomLevel;
    }

    public function isShowMapsTypeControl(): bool
    {
        return $this->showMapsTypeControl;
    }

    public function setShowMapsTypeControl(bool $showMapsTypeControl): void
    {
        $this->showMapsTypeControl = $showMapsTypeControl;
    }

    public function isShowFullscreenControl(): bool
    {
        return $this->showFullscreenControl;
    }

    public function setShowFullscreenControl(bool $showFullscreenControl): void
    {
        $this->showFullscreenControl = $showFullscreenControl;
    }

    public function isShowZoomControl(): bool
    {
        return $this->showZoomControl;
    }

    public function setShowZoomControl(bool $showZoomControl): void
    {
        $this->showZoomControl = $showZoomControl;
    }

    public function isShowStreetViewControl(): bool
    {
        return $this->showStreetViewControl;
    }

    public function setShowStreetViewControl(bool $showStreetViewControl): void
    {
        $this->showStreetViewControl = $showStreetViewControl;
    }

    public function isAllowScrollwheel(): bool
    {
        return $this->allowScrollwheel;
    }

    public function setAllowScrollwheel(bool $allowScrollwheel): void
    {
        $this->allowScrollwheel = $allowScrollwheel;
    }

    public function isAutoOpenInfoWindow(): bool
    {
        return $this->autoOpenInfoWindow;
    }

    public function setAutoOpenInfoWindow(bool $autoOpenInfoWindow): void
    {
        $this->autoOpenInfoWindow = $autoOpenInfoWindow;
    }

    public function getCustomMarker(): string
    {
        return $this->customMarker;
    }

    public function setCustomMarker(string $customMarker): void
    {
        $this->customMarker = $customMarker;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getMapsCity(): string
    {
        return $this->mapsCity;
    }

    public function setMapsCity(string $mapsCity): void
    {
        $this->mapsCity = $mapsCity;
    }

    public function getMapsStreet(): string
    {
        return $this->mapsStreet;
    }

    public function setMapsStreet(string $mapsStreet): void
    {
        $this->mapsStreet = $mapsStreet;
    }

    public function getMapsHouseNumber(): string
    {
        return $this->mapsHouseNumber;
    }

    public function setMapsHouseNumber(string $mapsHouseNumber): void
    {
        $this->mapsHouseNumber = $mapsHouseNumber;
    }

    public function getMapsHouseAddition(): string
    {
        return $this->mapsHouseAddition;
    }

    public function setMapsHouseAddition(string $mapsHouseAddition): void
    {
        $this->mapsHouseAddition = $mapsHouseAddition;
    }

    public function getMapsZipCode(): string
    {
        return $this->mapsZipCode;
    }

    public function setMapsZipCode(string $mapsZipCode): void
    {
        $this->mapsZipCode = $mapsZipCode;
    }

    public function getMapsPhoneNumber(): string
    {
        return $this->mapsPhoneNumber;
    }

    public function setMapsPhoneNumber(string $mapsPhoneNumber): void
    {
        $this->mapsPhoneNumber = $mapsPhoneNumber;
    }

    public function getMapsEmail(): string
    {
        return $this->mapsEmail;
    }

    public function setMapsEmail(string $mapsEmail): void
    {
        $this->mapsEmail = $mapsEmail;
    }

    public function toArray(): array
    {
        return [
            'full_width' => true,
            'class' => 'h-[300px] md:h-[400px] xl:h-[600px]',
            'map_height' => $this->getMapsHeight(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'title' => $this->getTitle(),
            'street' => $this->getMapsStreet(),
            'housenumber' => $this->getMapsHouseNumber(),
            'housenumber_addition' => $this->getMapsHouseAddition(),
            'postcode' => $this->getMapsZipCode(),
            'city' => $this->getMapsCity(),
            'phone' => $this->getMapsPhoneNumber(),
            'email' => $this->getMapsEmail(),
            'zoom_level' => $this->getMapsZoomLevel(),
            'map_type' => $this->getMapsType(),
            'show_map_type_control' => $this->isShowMapsTypeControl(),
            'show_street_view_control' => $this->isShowStreetViewControl(),
            'show_fullscreen_control' => $this->isShowFullscreenControl(),
            'show_zoom_control' => $this->isShowZoomControl(),
            'allow_scrollwheel' => $this->isAllowScrollwheel(),
            'auto_open_info_window' => $this->isAutoOpenInfoWindow(),
            'map_style' => $this->getMapsStyling(),
            'custom_marker' => $this->getCustomMarker(),
        ];
    }



}