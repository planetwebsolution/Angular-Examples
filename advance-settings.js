/*!
 * Advance Settings
 * Version 0.0.1-ad.1-2015.06.23
 */

angular.module('advanceSettings', [])

        //Set your configuration for bootstrap
        .config([function () {

            }])

        //Main function to bootstrap APP
        .run(['$rootScope', 'CampaignsService', function ($rootScope, CampaignsService) {
                CampaignsService.init();
            }])


        //Common Ajax factory to make ajax requests and assign results in controller's scope
        .factory('AjaxRequests', ['$http', function ($http) {
                return {
                    getCampaignsData: function () {
                        var data = null, campaigns
                        return $http.get(SITEURL + 'campaigns/get_all_campaigns/' + data + '/' + true).then(function (response) {
                            campaigns = response.data;
                            return campaigns;
                        });
                    }
                }
            }])

        //Singleton class for campaign services
        .service('CampaignsService', ['$rootScope', '$http', '$timeout', function ($rootScope, $http, $timeout) {
                var self = this;
                this.percentModelSelected = [], this.campaignSelectSelected = [], this.siteUrl = SITEURL, this.camps = [], this.percentModel = [], this.campaignSelect = [], this.percentDropDownOptions = [];
                this.selectCounter = 0, this.campaign_id, this.showPercentDefault = 100, this.defaultSpilitCalc = 100, this.percentIncreaseCounter = 0;

                this.init = function () {
                    var campaigns2;
                    $http.get(SITEURL + 'campaigns/get_all_campaigns/').then(function (response) {
                        self.camps = response.data;

                        //To assign first time selected campaigns
                        selectedCampaigns = JSON.parse(selectedCampaigns);
                        angular.forEach(selectedCampaigns.CampaignSplitTesting, function (campaign, key) {
                            var camp = {Campaign: campaign.Campaign, percent: campaign.value}, sum = 0;
                            self.addNewRow(key, camp);

                            self.campaignSelectSelected[key] = campaign.Campaign.title;
                            self.percentModelSelected[key] = campaign.value;

                        })
                    });

                    this.$rowsData = {
                        current: this.getCurrentCampaign()
                                .then(function (response) {
                                    var campObj = {};
                                    campObj = {Campaign: response.data.Campaign, 'percent': 100, 'url': SITEURL + 'shop/' + response.data.Campaign.slug};
                                    self.assignValues(campObj);
                                }),
                        subItems: []
                    };

                };

                this.assignValues = function (data) {
                    this.$rowsData.current = data;
                }

                //Get First data of campaigns
                this.getRows = function () {
                    return this.$rowsData;
                }

                //To get current campaign detail
                this.getCurrentCampaign = function () {
                    var id = angular.element(document.querySelector("#whatIsCampId")).html(); //Should pick another option
                    return $http.get(SITEURL + 'campaigns/getCampaignDetail/' + id);
                }

                this.getAjax = function () {
                    var test = null, campaigns;
                    $http.get(SITEURL + 'campaigns/get_all_campaigns/' + test + '/' + true).then(function (response) {
                        campaigns = response.data;
                        return campaigns;
                    });
                }

                this.removeRow = function ($index) {

                    var remove = this.$rowsData.subItems;
                    var id = angular.element(document.querySelector("#whatIsCampId")).html();
                    var campDetail = this.$rowsData.subItems[$index];
                    $http.post(SITEURL + 'campaigns/delete_split_record/', {campaign_id: id, target_campaign_id: campDetail.Campaign.id}).then(function (response) {
                        if (response.data.status) {
                            remove.splice($index, 1);
                            self.$rowsData.subItems = remove;
                            self.wow();
                        }
                    }, "json");

                }

                this.addNewRow = function ($index, campObj) {
                    var arrSelectedCamp = this.campaignSelect;
                    var allCampsList = this.camps;

                    angular.forEach(allCampsList.campaigns, function (data, key) {
                        angular.forEach(arrSelectedCamp, function (dataInner, keyInner) {
                            if (data.Campaign.id === dataInner) {
                                allCampsList.campaigns.splice(key, 1);
                            }
                        })
                    })

                    var small = this.percentModel, nextRowInit = 0;

                    if (typeof campObj != "undefined") {
                        var currRow = campObj;
                    } else {
                        var currRow = {"Campaign": {"id": "2", "title"
                                        : "camp title second", "slug": "camp-1"}, "percent": 0};
                    }

                    this.getRows().subItems.push(currRow);

                    angular.forEach(small, function (data, key) {
                        nextRowInit += data;
                    })

                    if (nextRowInit >= 100) {
                        nextRowInit = 100;
                    }

                    //Code to remove selected campaigns in drop down
                    var campItems = this.camps;
                    var selctedCamp = this.campaignSelect;

                    this.defaultSpilitCalc = 100 - nextRowInit;
                    this.percentDropDownOptions.push(this.showPercentDropDown(this.percentIncreaseCounter));
                    this.selectCounter++;
                    this.percentIncreaseCounter++;
                }

                this.calculatePercentages = function (index) {
                    angular.forEach(this.getRows().current, function (data, key) {
                        if (key == index) {
                            console.log(data);
                        }
                    })
                }

                this.showPercentDropDown = function ($index) {

                    var localScope = 0, start = 0;

                    var final = [];

                    for (start; start <= this.defaultSpilitCalc; start += 10) {
                        final.push(start);
                    }

                    return {
                        'values': final
                    };
                }

                this.wow = function (valueWa, keyWa) {

                    var percentArray = this.percentModel;

                    var localScope = 0, start = 0;

                    angular.forEach(percentArray, function (data, key) {
                        localScope += data;
                    })

                    if (localScope >= 100) {
                        localScope = 100;
                    }

                    this.showPercentDefault = 100 - localScope;
                }

                this.updateSubItems = function (index, value) {
                    var campaignsData = this.camps;
                    var targetSubItems = this.getRows().subItems;
                    angular.forEach(campaignsData.campaigns, function (camp, key) {
                        if (camp.Campaign.id == value) {
                            targetSubItems[index].Campaign.slug = camp.Campaign.slug;
                            targetSubItems[index].Campaign.id = camp.Campaign.id;
                            targetSubItems[index].Campaign.title = camp.Campaign.title;
                        }
                    })

                }

            }])

        //Controller registration 
        .controller('AdvanceSettingsController', ['$scope', 'CampaignsService', 'AjaxRequests', function ($scope, CampaignsService, AjaxRequests) {
                $scope.init = function () {
                    $scope.CampaignsService = CampaignsService;
                }
                $scope.init(); // call init function at very first time.
            }
        ])

        //Filters used by the APP needs to be init here
        .filter('percentage', ['$filter', function ($filter) {
                return function (input) {
                    input = $filter(input) + '%';
                };
                return input;
            }])

        //Provider to set version
        .value('version', '0.0.1-ad.1');
;
'use strict';