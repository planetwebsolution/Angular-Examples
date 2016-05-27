<?php
echo $this->element('front/campaigns/sub_menus', array('campaign' => $facebookPixel));
echo $this->start('right-top-btn');
echo $this->Html->link("Show Campaign", array(
    "controller" => "campaigns",
    "action" => "buy",
    'slug' => $facebookPixel['Campaign']['slug']
        ), array(
    "class" => "btn btn-info",
    "target" => "_blank"
));
echo $this->end();
echo $this->Session->flash('front');
extract($this->request->data);
?>

<div class="row center-block">
    <div class="clearfix visible-xs-block"></div>
    <?php
    echo $this->Form->create('Campaign', array('inputDefaults' =>
        $this->Layout->bootstrapformSetting(12), 'type' => 'post',
        'class' => 'validatate_form form-horizontal send_draft_email',
        'noValidate' => true,
    ));
    ?>

    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h1 class="panel-title">Relaunching</h1>
                <div class="pull-right"></div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">

                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                $options = array(0 => 'Never');
                                $attributes = array('legend' => false, "label" => array("class" => "pointer"));
                                echo $this->Form->radio('relaunch', $options, $attributes);
                                ?>
                                <p style="margin-left: 28px; color: #999">
                                    Campaign will end as one-off campaign.
                                </p>
                            </div>
                            <div class="col-sm-12">
                                <?php
                                $options = array(1 => 'Immediately after campaign finishes');
                                $attributes = array('legend' => false, "label" => array("class" => "pointer"));
                                echo $this->Form->radio('relaunch', $options, $attributes);
                                ?>
                                <p style="margin-left: 28px; color: #999">
                                    Regardless of the success, campaign will launch again.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="col-md-12">
            <div class="">
                <div class="panel-body">
                    <p> Relaunching campaign after it is finished is useful for popular campaigns.  </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h1 class="panel-title">End Campaign</h1>
            </div>
            <div class="panel-body text-center">
                <?php if ($this->request->data["Campaign"]["is_ended"]) { ?>
                    <div class="col-md-12">
                        <p>You've ended this campaign. You can't modify again.</p>
                    </div>
                <?php } else { ?>
                    <div class="col-md-4">
                        <span class="arrow"></span>
                        <?php
                        echo $this->Html->link('End Campaign', array("action" => "end_campaign", $id), array('class' => 'radius5px btn btn-info btn-3d'));
                        ?>
                    </div>
                    <div class="col-md-8">
                        <div class="panel-heading">
                            <h1 class="panel-title">If you decide so, you can end the campaign before its scheduled end date. </h1>
                        </div>
                        <span class="arrow"></span>
                        <div class="timeline-icon">
                        </div>
                        <p>If the campaign is tilted, all orders will be printed and prepared for shipping. But beware once you do this there is no going back.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php if ($this->request->data["Campaign"]["order_count"] >= 10) { ?>
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h1 class="panel-title">Goal Drop</h1>
                </div>
                <div class="panel-body text-center">

                    <div class="col-md-12" >
                        <div class="col-md-4 pull-left" >
                            <?php
                            echo $this->Form->input('goal_drop', array('label' => false, 'div' => '', 'type' => 'checkbox', 'class' => 'form-control make-switch', 'data-on-text' => "On", 'data-off-text' => "Off"));
                            ?>
                        </div>
                        <div class="col-md-8">
                            <p>Full fill the campaign even if the goal is not met</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h1 class="panel-title">Campaign Dormant</h1>
            </div>
            <div class="panel-body text-center">

                <div class="col-md-12" >
                    <div class="col-md-4 pull-left" >
                        <?php
                        echo $this->Form->input('is_dormant', array('label' => false, 'div' => '', 'type' => 'checkbox', 'class' => 'form-control make-switch', 'data-on-text' => "On", 'data-off-text' => "Off"));
                        ?>
                    </div>
                    <div class="col-md-8">
                        <p>Enable or disable your campaign dormant setting.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="col-md-12">
            <div class="">
                <div class="panel-body">
                    <p> Campaigns with goal drop enabled will be fulfilled even if their goal is not met. This is especially useful for campaigns that would nearly met their goal. </p>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h1 class="panel-title">Cross Selling</h1>
            </div>
            <div class="panel-body text-center">
                <div class="col-md-12">
                    <div class="panel-heading">
                        <h1 class="panel-title-h1">Campaigns shown on order page</h1>
                        <?php echo $this->Form->input('CampaignCross', array('label' => false, 'class' => "form-control select2_sample2", 'data-fv-notempty-message' => __('notEmpty'), "multiple" => true, 'placeholder' => "Select Campaign", "options" => $all_campaigns)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="col-md-12">
            <div class="">
                <div class="panel-body">
                    <p> The cross selling option will enable you to promote your other related campaigns on Represent to buyers. The campaigns listed above will be displayed on the order confirmation page seen by a buyer of your shirt. </p>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12" >
        <div class="panel">
            <div class="panel-heading">
                <h1 class="panel-title">Split testing</h1>
            </div>

            <div class="panel-body">
                <div class="col-md-12">

                    <div class="panel-body" >
                        <span class="hide" id="whatIsCampId"><?php echo $id; ?></span>
                        <div data-ng-app="advanceSettings" data-ng-init="campaign_id = <?php echo $id; ?>;" data-ng-cloak >
                            <div  data-ng-controller="AdvanceSettingsController" >

                                <div id="p_scents">
                                    <div class="row"> 
                                        <div class="col-sm-2">
                                            <select class="form-control" ng-disabled="true">
                                                <option selected="" ng-model="CampaignsService.showPercentDefault" value="{{CampaignsService.showPercentDefault}}%">{{CampaignsService.showPercentDefault}} %</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2" style="line-height: 32px">
                                            of visitors send to
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input text">
                                                <input type="text" class="form-control" readonly value="{{CampaignsService.getRows().current.Campaign.title}}" />
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <a class="btn btn-default" target="_blank" ng-href="{{CampaignsService.getRows().current.url}}">Show campaign</a>
                                        </div>
                                    </div>

                                    <div class="row" ng-repeat="row in CampaignsService.getRows().subItems track by $index">
                                        <div class="col-sm-2" ng-if="CampaignsService.percentModelSelected[$index] != null">
                                            {{CampaignsService.percentModelSelected[$index] * 10}}%
                                        </div>

                                        <div class="col-sm-2" ng-if="CampaignsService.percentModelSelected[$index] == null"> 
                                            <select class="form-control dropDownPercent" name="data[CampaignSplitTesting][{{$index}}][value]" ng-model="CampaignsService.percentModel[$index]" ng-change="CampaignsService.wow(CampaignsService.percentModel[$index], $index)" ng-options="o as o for o in CampaignsService.percentDropDownOptions[$index].values">
                                            </select>
                                        </div>
                                        <div class="col-sm-2" style="line-height: 32px">
                                            of visitors send to
                                        </div>

                                        <div class="col-sm-4" ng-if="CampaignsService.campaignSelectSelected[$index] != null">
                                            {{CampaignsService.campaignSelectSelected[$index]}}
                                        </div>
                                        <div class="col-sm-4" ng-if="CampaignsService.campaignSelectSelected[$index] == null">
                                            <select class="form-control" 
                                                    name="data[CampaignSplitTesting][{{$index}}][target_campaign_id]" 
                                                    ng-change="CampaignsService.updateSubItems($index, CampaignsService.campaignSelect[$index])" 
                                                    ng-model="CampaignsService.campaignSelect[$index]">
                                                <option>Please select</option>
                                                <option data-ng-repeat="camp in CampaignsService.camps" 
                                                        value="{{camp.Campaign.id}}" 
                                                        ng-selected="CampaignsService.campaignSelectSelected[$index] == 1 ? true : false ">{{camp.Campaign.title}}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <a class="btn btn-default" target="_blank" href="{{CampaignsService.siteUrl}}shop/{{row.Campaign.slug}}">Show campaign</a>
                                        </div>
                                        <div class="col-sm-2">
                                            <a class="btn btn-danger" ng-click="CampaignsService.removeRow($index)" href="javascript:void(0);">Remove campaign</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2"><a href ng-click="CampaignsService.addNewRow()" class="btn btn-small">Add Camapign</a></div>
                                    </tr>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="col-md-12">
            <div class="">
                <div class="panel-body">
                    <p>Split testing lets you to send portion of users opening This is a preview of how your campaign wil campaign to one or more other campaigns. This lets you test the performance of multiple campaigns/designs/stories at once.</p>
                    <p>We suggest starting with exploration - spreading your incoming users evenly among all the campaigns in the test. Once you gain enough confidence in your results you can route all the visitors to the best performing campaign to maximize your total profit.</p>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($CampaignSplitTesting)) { ?>
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h1 class="panel-title">Split test reports</h1>
                </div>

                <div class="panel-body">

                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Campaign Name</th>
                                <th>Total sale</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($CampaignSplitTesting as $single) { ?>
                                <tr>
                                    <td><?php echo Inflector::humanize($single['Campaign']["title"]); ?></td>
                                    <td><?php echo $split_report[$single['Campaign']["id"]]; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>


    <div class="col-sm-12">
        <div class="col-md-12">
            <div class="pull-right">
                <div class="panel-body">
                    <?php echo $this->Form->submit('Save Changes', array('class' => "btn btn-info btn-3d")); ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->Form->end(); ?>

    <?php
    echo $this->start("footer_js");
    ?>
    <script>
        var SITEURL = '<?php echo Router::url("/", true); ?>';
        var selectedCampaigns = '<?php echo json_encode($this->request->data); ?>';
    </script>
    <?php
    echo $this->Html->script('front/js/angular-route');
    echo $this->Html->script('front/js/advance-settings');
    ?>
    <script>
        jQuery(document).ready(function () {
            Teerific.mainCampaignView();
            Metronic.init(); // init metronic core components
        });
    </script>
    <?php echo $this->end(); ?>
</div>


