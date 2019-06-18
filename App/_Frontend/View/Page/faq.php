<div class="container">
<div class="section" id="faq">
  <div class="row">
    <div class="col s12">
      <div id="faq-search" class="card z-depth-0 faq-search-image center-align p-35">
        <div class="card-content">
          <h5>Frequently asked questions.</h5>
          <p class="mb-3">Search our help center for quick answers</p>
        </div>
      </div>
    </div>
  </div>
  <div class="faq row">
    <div class="col s12 m6 l3">
      <a class="black-text" href="javascript:void(0)">
        <div class="card z-depth-0 grey lighten-3 faq-card">
          <div class="card-content center-align">
            <i class="material-icons dp48 orange-text">search</i>
            <h6><b>Guides</b></h6>
          </div>
        </div>
      </a>
    </div>
    <div class="col s12 m6 l3">
      <a class="black-text" href="javascript:void(0)">
        <div class="card z-depth-0 grey lighten-3 faq-card">
          <div class="card-content center-align">
            <i class="material-icons dp48 red-text">chat_bubble_outline</i>
            <h6><b>FAQ</b></h6>
          </div>
        </div>
      </a>
    </div>
    <div class="col s12 m6 l3">
      <a class="black-text" href="javascript:void(0)">
        <div class="card z-depth-0 grey lighten-3 faq-card">
          <div class="card-content center-align">
            <i class="material-icons dp48 green-text">perm_identity</i>
            <h6><b>Community</b></h6>
          </div>
        </div>
      </a>
    </div>
    <div class="col s12 m6 l3">
      <a class="black-text" href="javascript:void(0)">
        <div class="card z-depth-0 grey lighten-3 faq-card">
          <div class="card-content center-align">
            <i class="material-icons dp48 blue-text">content_copy</i>
            <h6><b>Invoices</b></h6>
          </div>
        </div>
      </a>
    </div>
    <div class="col s12 m3 l3 pin-top pushpin">
      <div class="card mt-2 z-depth-0">
        <div class="card-content">
          <span class="card-title">Tempest Support</span>
          <div class="category-list">
              <div class="row">
              <div class="col hide-on-small-only m3 l2">
                <ul class="section table-of-contents">
                  <li><a href="#order">Order</a></li>
                  <li><a href="#warranty">warranty</a></li>
                  <li><a href="#shipping">Shipping</a></li>
                </ul>
              </div>
            </div>
          </div>
          <span class="card-title mt-10">Supporters</span>
        </div>
      </div>
    </div>
    <div class="col s12 m9 l9">
        <?php 
        $faq['order'] = array("title" =>  "Ordering",
                              "data"  =>  array(array("q" =>  "Payment methods",
                                                      "a" =>  "We accept credit cards such as American Express, Discover, MasterCard, Visa, as well as PayPal and PayPal Credit."),
                                                array("q" =>  "Retailers",
                                                      "a" =>  "All our products can be purchased from this online store as well as our official Amazon and eBay seller accounts which can be found here:
                                                              <br/>
                                                              <br/>• Amazon
                                                              <br/>• eBay"
                                                              ),
                                                array("q" =>  "Approval and Processing",
                                                      "a" =>  "Once your order has been approved, you will receive a confirmation email from us. Usually this will occur within 24-48 hours of receiving your order. Please contact us if you have not received a confirmation email from us outside of 48 hours."
                                                      ),
                                                array("q" =>  "Back Orders",
                                                      "a" =>  "Sometimes we have not yet been able to replenish our inventory so we will immediately reach out to you via your preferred contact method and let you know. We will also provide you some options, including order substitutes as well as the option to wait for your original order at a discount for your trouble."
                                                      ),                                                
                                                  ),
                              );
        $faq['shipping'] = array("title" =>  "Shipping",
                              "data"  =>  array(array("q" =>  "Free Shipping",
                                                      "a" =>  "We are proud to offer free ground shipping within the 48 contiguous United States. Estimated delivery times are as follows:
                                                              <br/>
                                                              <br/>• East Coast – 1-3 business days
                                                              <br/>• MidWest – 2-4 business days
                                                              <br/>• SouthWest – 2-5 business days
                                                              <br/>• West Coast – 3-6 business days
                                                              "),
                                                array("q" =>  "Tracking",
                                                      "a" =>  "You will receive an email with your order’s tracking number as long as you provide a valid email address. Otherwise, you can also contact us for tracking information."
                                                              ),                                         
                                                  ),
        $faq['warranty'] = array("title" =>  "Warranty and Returns",
                              "data"  =>  array(
                                                array("q" =>  "Our Policy",
                                                      "a" =>  "Returns will only be accepted within 30 days from the original purchase date, and ONLY if we have issued you a Return Merchandise Authorization (RMA) number. Please check all merchandise for damage or defect upon receipt of the order, before the item is used or installed. Contact us via phone or email to initiate the Return process.
                                                      "),
                                                array("q" =>  "1-Year Warranty",
                                                      "a" =>  "All Tempest™ Freezers are backed by a 1-Year Warranty. Coverage includes defects in material and construction from the date of purchase by the original purchaser. This does not apply to products subjected to misuse, mishandling, neglect or alteration."
                                                              ),
                                                array("q" =>  "Damaged Shipment",
                                                      "a" =>  "If your product order arrives with obvious signs of damage, contact us immediately and we will set up a UPS claim for the product. We may request for pictures to assist with the claim and to ship you a replacement. "
                                                              ),
                                                ),   
                                                ),
                              );
      foreach($faq as $key => $value):?>
      <div class="row">
        <div class="col s12 section scrollspy" id="<?php echo $key;?>">
      <h6><?php echo $value['title'];?></h6>
      <ul class="collapsible categories-collapsible z-depth-0">
        <?php 
        $active = "active";
        foreach($value['data'] as $k => $v):?>
        <li class="<?php echo $active;?>">
          <div class="collapsible-header" tabindex="0"><?php echo "Q:   " . $v['q'] ?><i class="material-icons">
              keyboard_arrow_right </i></div>
          <div class="collapsible-body" style="">
            <p><?php echo "A:   " . $v['a'] ?></p>
          </div>
        </li>
      <?php 
      $active = '';
      endforeach;?>
      </ul>
    </div>
    </div>
      <?php 
      endforeach;?>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  // Or with jQuery

  $(document).ready(function(){
    $('.collapsible').collapsible();

    $('.scrollspy').scrollSpy();
  });
  </script>