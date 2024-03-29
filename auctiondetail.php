<?php
$title = "Auctions";
$needTimer = true;
require_once("db.php");
include "header.php";
?>

<?php
$id = $_GET['a'];
echo "<script>var auctionID = '" . $id . "';</script>";
if ($loggedIn) {
    if (isset($id)) {
        //Get Auction Data
        $query  = "SELECT *
                FROM auctions
                WHERE auctionID = :id
                ";
        $params = array(
            ':id' => $id
        );
        $stmt   = $db->prepare($query);
        $stmt->execute($params);
        $auction = $stmt->fetch();
        $auctionName = $auction['title'];

        $query  = "SELECT MAX(b.bidID) as currentBid, p.*, m.*
                  FROM members m
                  INNER JOIN property p on p.propertyID = m.propertyID
                  LEFT JOIN bids b ON b.memberID = m.memberID
                  WHERE m.auctionID = :id
                  GROUP BY m.memberID
                ";
        $params = array(
            ':id' => $id
        );
        $stmt   = $db->prepare($query);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            $members = $stmt->fetchAll();
            //Loop through each member of the auction
            foreach ($members as $member) {
              if ($member['ownerID'] == $userID) {
                $myProperty = $member['propertyID'];
                $myPropertyMember = $member['memberID'];
              }
            }
        }

        //Form to input your next bid
        if (isset($myProperty)) {
          $query  = "SELECT *
                    FROM bids
                    WHERE memberID = :id
                    ORDER BY bidID  DESC
                    LIMIT 1
                  ";

          $params = array(
              ':id' => $myPropertyMember
          );
          $stmt   = $db->prepare($query);
          $stmt->execute($params);
          $myBid = $stmt->fetch();
        }

        if ($auction['ownerID'] == $userID) {
            $owner = true;
        } else {
          $owner = false;
        }
    }

}
?>

<div class="auctionOverview">
  <div class='container'>
    <div class="clearfix">

    </div>
    <h2 class="auctionName">
      <?php echo $auctionName; ?>
    </h2>

    <div class="properties">
          <div class="property property1">
        <div class="propertyName propertyName1">
          Property
        </div>
              <div class="propertyLine propertyLine1">

              </div>
        <div class="propertyValueWrapper propertyValueWrapper1">
          <p class="propertyValue propertyValue1">
            $0
          </p>
        </div>
              <div class="propertyImgWrapper propertyImgWrapper1">
                  <div class="propertyImg propertyImg1">

                  </div>
              </div>
          </div>
          <div class="property property2">
        <div class="propertyName propertyName1">
          Property
        </div>
              <div class="propertyLine propertyLine2">

              </div>
        <div class="propertyValueWrapper propertyValueWrapper2">
          <p class="propertyValue propertyValue2">
            $0
          </p>
        </div>
              <div class="propertyImgWrapper propertyImgWrapper2">
                  <div class="propertyImg propertyImg2">

                  </div>
              </div>
          </div>
          <div class="property property3">
        <div class="propertyName propertyName1">
          Property
        </div>
              <div class="propertyLine propertyLine3">

              </div>
        <div class="propertyValueWrapper propertyValueWrapper3">
          <p class="propertyValue propertyValue3">
            $0
          </p>
        </div>
              <div class="propertyImgWrapper propertyImgWrapper3">
                  <div class="propertyImg propertyImg3">

                  </div>
              </div>
          </div>
      </div>
    <div class="finishLine">

    </div>
    <div class="preferences">
      <div class="clientLogo">
        <img src="/templates/css/assets/bank.png" />
      </div>
      <div class="prefList">
        <ul>
          <li class='priorityPref' id="li1">
            1. Price Per Square Foot
          </li>
          <li id="li2">
            2. Term
          </li>
          <li id="li3">
            3. Free Rent
          </li>
          <li id="li4">
            4. Tenant Improvement
          </li>
          <li id="li5">
            5. Escalation
          </li>

        </ul>
      </div>
    </div>

  </div>
</div>

<?php
  if (isset($myProperty)) {
    include "bidbox.php";
  }
 ?>

<div class="barGraphs">
  <div class="container">
    <div class="clearfix">

    </div>
    <h2 class="auctionName">
      Auction Properties
    </h2>

    <div class="propStats">
      <div class="propStat propStat1">
        <h4 class="propName">
          Property Name
        </h4>
        <div class="propFact propFact1">
          <img class="factIcon" src="/templates/css/assets/trophy.png"/>
          <p class="factNum factNum1">
            NUM
          </p>
        </div>
        <div class="propFact propFact2">
          <img class="factIcon" src="/templates/css/assets/money.png"/>
          <p class="factNum factNum2">
            NUM2
          </p>
        </div>
      </div>
      <div class="propStat propStat2">
        <h4 class="propName">
          Property Name
        </h4>
        <div class="propFact propFact1">
          <img class="factIcon" src="/templates/css/assets/trophy.png"/>
          <p class="factNum factNum1">
            NUM
          </p>
        </div>
        <div class="propFact propFact2">
          <img class="factIcon" src="/templates/css/assets/money.png"/>
          <p class="factNum factNum2">
            NUM2
          </p>
        </div>
      </div>
      <div class="propStat propStat3">
        <h4 class="propName">
          Property Name
        </h4>
        <div class="propFact propFact1">
          <img class="factIcon" src="/templates/css/assets/trophy.png"/>
          <p class="factNum factNum1">
            NUM
          </p>
        </div>
        <div class="propFact propFact2">
          <img class="factIcon" src="/templates/css/assets/money.png"/>
          <p class="factNum factNum2">
            NUM2
          </p>
        </div>
      </div>


    </div>

    <div class="bars">
          <div class="var var1">
              <div class="varNameDiv varNameDiv0">
                  <p class="varName varName0">
                      Price Per Square Foot ($/sq-ft)
                  </p>
              </div>
              <div class="graph graph1">
                  <div class="barsWrapper">

                      <div class="bar bar1">
                          <p class="barVal barVal1">
                              $0
                          </p>
                      </div>
                      <div class="bar bar2">
                          <p class="barVal barVal2">
                              $0
                          </p>
                      </div>
                      <div class="bar bar3">
                          <p class="barVal barVal3">
                              $0
                          </p>
                      </div>

                  </div>
                  <div class="pref pref1">
                      <p class="prefVal prefVal1">
                          .0
                      </p>
                  </div>
              </div>
          </div>
          <div class="var var2">
              <div class="varNameDiv varNameDiv1">
                  <p class="varName varName1">
                      Tenant Improvement ($/sq-ft)
                  </p>
              </div>
              <div class="graph graph1">
                  <div class="barsWrapper">

                      <div class="bar bar1">
                          <p class="barVal barVal1">
                              $0
                          </p>
                      </div>
                      <div class="bar bar2">
                          <p class="barVal barVal2">
                              $0
                          </p>
                      </div>
                      <div class="bar bar3">
                          <p class="barVal barVal3">
                              $0
                          </p>
                      </div>

                  </div>
                  <div class="pref pref1">
                      <p class="prefVal prefVal1">
                          .0
                      </p>
                  </div>
              </div>
          </div>
          <div class="var var3">
              <div class="varNameDiv varNameDiv1">
                  <p class="varName varName1">
                      Free Rent (months)
                  </p>
              </div>
              <div class="graph graph1">
                  <div class="barsWrapper">

                      <div class="bar bar1">
                          <p class="barVal barVal1">
                              $0
                          </p>
                      </div>
                      <div class="bar bar2">
                          <p class="barVal barVal2">
                              $0
                          </p>
                      </div>
                      <div class="bar bar3">
                          <p class="barVal barVal3">
                              $0
                          </p>
                      </div>

                  </div>
                  <div class="pref pref1">
                      <p class="prefVal prefVal1">
                          .0
                      </p>
                  </div>
              </div>
          </div>
          <div class="var var4">
              <div class="varNameDiv varNameDiv1">
                  <p class="varName varName1">
                      Escalation (%/yr)
                  </p>
              </div>
              <div class="graph graph1">
                  <div class="barsWrapper">

                      <div class="bar bar1">
                          <p class="barVal barVal1">
                              $0
                          </p>
                      </div>
                      <div class="bar bar2">
                          <p class="barVal barVal2">
                              $0
                          </p>
                      </div>
                      <div class="bar bar3">
                          <p class="barVal barVal3">
                              $0
                          </p>
                      </div>

                  </div>
                  <div class="pref pref1">
                      <p class="prefVal prefVal1">
                          .0
                      </p>
                  </div>
              </div>
          </div>
          <div class="var var5">
              <div class="varNameDiv varNameDiv1">
                  <p class="varName varName1">
                      Term (years)
                  </p>
              </div>
              <div class="graph graph1">
                  <div class="barsWrapper">

                      <div class="bar bar1">
                          <p class="barVal barVal1">
                              $0
                          </p>
                      </div>
                      <div class="bar bar2">
                          <p class="barVal barVal2">
                              $0
                          </p>
                      </div>
                      <div class="bar bar3">
                          <p class="barVal barVal3">
                              $0
                          </p>
                      </div>

                  </div>
                  <div class="pref pref1">
                      <p class="prefVal prefVal1">
                          .0
                      </p>
                  </div>
              </div>
          </div>
          <hr class="graphHR graphHR1" />
          <hr class="graphHR graphHR2" />
          <hr class="graphHR graphHR3" />
          <hr class="graphHR graphHR4" />
          <hr class="graphHR graphHR5" />
      </div>
  </div>
</div>


 <?php
include "footer.php";
?>
