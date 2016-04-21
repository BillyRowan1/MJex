@extends('master')

@section('main')
    <section class="cd-faq">
        <ul class="cd-faq-categories">
            <li><a class="selected" href="#faq-group-1">Signup FAQ</a></li>
            <li><a href="#faq-group-2">Other FAQ</a></li>
        </ul> <!-- cd-faq-categories -->

        <div class="cd-faq-items">
            <ul id="faq-group-1" class="cd-faq-group">
                <li class="cd-faq-title"><h2>Signup FAQ</h2></li>
                <li>
                    <a class="cd-faq-trigger" href="#0">What the difference in Signup Plans ?</a>
                    <div class="cd-faq-content">
                        <p>
                        <ul>
                            <li>Free Ads- give you (1) One Basic Weekly Classified Ad. <br>
                                Additional (1 line) Basic Weekly ads are $ 2 each</li>
                            <li>Weekly Ads- Gives you larger ads (2 lines) with Premium placement.</li>
                            <li>Weekly Pro- Gives even larger ads (3 lines) Premium placement,
                                also includes one Banner Ad rotating around the Exchange.</li>
                            <li>Ad Network- Allows more Paid banner ads. These will rotate depending around the Exchange.
                                <br> *Contact us for further info</li>
                        </ul>
                        </p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">How long do ads last?</a>
                    <div class="cd-faq-content">
                        <p>All ads expire after 7 days. If you want you can repost an expired ad or edit and repost.</p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Can I signup as a Seller, Grower and a Business ?</a>
                    <div class="cd-faq-content">
                        <p>Yes, upgrade all of them.</p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Can I have both a Seeker and Seller Account?</a>
                    <div class="cd-faq-content">
                        <p>Yes, it’s okay to have one account each.</p>
                    </div> <!-- cd-faq-content -->
                </li>

            </ul> <!-- cd-faq-group -->
            <ul id="faq-group-2" class="cd-faq-group">
                <li class="cd-faq-title"><h2>Other FAQ</h2></li>
                <li>
                    <a class="cd-faq-trigger" href="#0">After I place an order in a seller's store, do I pay you and then you pay the seller?
                    </a>
                    <div class="cd-faq-content">
                        <p>
                            No. We only provide a means to connect seekers and sellers and all transactions are agreed to and handled by the seekers and sellers themselves. Using anonymous emails and the onsite chat function seekers and sellers come together to discuss product, orders, payment and delivery issues.
                        </p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Who can get a medical marijuana card?</a>
                    <div class="cd-faq-content">
                        <p>Most cases, persons with a qualifying medical conditions and a recommendation for medical marijuana from a physician may apply for a medical marijuana card. Each individual State has its own regulations check your current State laws for this info.</p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Do I need a physician to recommend the use of medical marijuana?</a>
                    <div class="cd-faq-content">
                        <p>Yes. A physician must state in writing that the patient has a qualifying medical condition and that medical marijuana may lessen or relieve the symptoms or effects of that condition annually.
                        </p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">Can medical marijuana dispensaries sell marijuana to retail customers who do not have a Medical card?</a>
                    <div class="cd-faq-content">
                        <p>Yes. Depending on each state laws medical marijuana dispensaries may choose to participate in early retail sales of limited recreational marijuana products.
                        </p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a class="cd-faq-trigger" href="#0">How can I verify that I am a grower or caregiver for a particular patient?</a>
                    <div class="cd-faq-content">
                        <p>The Card Holder will contact you and it’s the Growers choice to accept the invitation.
                            The patient is responsible for getting the cards to the caregiver and grower. You can ask the patient to sign an approved Authorization for Use and Disclosure of Information form that will enable you to contact the State and verify whether you are an authorized grower or caregiver for that patient.
                        </p>
                    </div> <!-- cd-faq-content -->
                </li>

                <li>
                    <a href="#" class="cd-faq-trigger">Who may act as a grower?</a>
                    <div class="cd-faq-content">
                        <p>Check your State Laws but normally,
                            -A patient may grow for his or herself or designate an individual 18 years or older to act as his or her grower.
                            <br>
                            -They conduct a criminal background check on all designated growers. <br>
                            -If a grower has been convicted of felony violating ORS 475.840 through 475.920 on or after January 1, 2006, that person is prohibited from growing marijuana for a patient for five years from the date of conviction for the first offense.
                            <br>
                            -Individuals with more than one conviction are permanently prohibited from growing. <br>
                        </p>
                    </div>
                </li>

                <li>
                    <a href="#" class="cd-faq-trigger">What are marijuana-infused liquids and concentrates?
                    </a>
                    <div class="cd-faq-content">
                        <p>Marijuana comes in many forms, from sodas and pizzas to tinctures and lotions. Liquids include sodas and other beverages infused with marijuana. Extracts are a concentrated form of marijuana, such as butane hash oil. Extracts or concentrates are often consumed in portable device called vape pens.
                        </p>
                    </div>
                </li>

                <li>
                    <a href="#" class="cd-faq-trigger">Say I grow four plants and they produce more usable marijuana than the law allows me to possess. What should I do?
                    </a>
                    <div class="cd-faq-content">
                        <p>If you live alone and harvest four plants at the same time, you may end up going over the 8-ounce possession limit. If you've got roommates, you may not have to worry since you can spread the usable marijuana across each member of the household.
                            <br>
                            If you exceed the possession limits, you have a couple of options: Consume it. Share with others who are 21 or older. Donate it to medical marijuana patients. Or destroy it.
                        </p>
                    </div>
                </li>

                <li>
                    <a href="#" class="cd-faq-trigger">What types of Marijuana are available?</a>
                    <div class="cd-faq-content">
                        <p>In addition to a diverse strain of flowers (or bud), you can also find marijuana in many different forms for sale. Hash, hash oil, kief, edibles (such as baked goods or candies) and THC capsules are all readily available for your enjoyment.
                        </p>
                    </div>
                </li>

                <li>
                    <a href="#" class="cd-faq-trigger">Do I have to notify anyone – the government or the police -- that I am growing my own pot?
                    </a>
                    <div class="cd-faq-content">
                        <p>No. There are no reporting requirements for growing your own marijuana at home recreationally in your legal State or Province, always check the laws.  Just Signup and ask someone whose close by, the Exchange is very friendly network.
                        </p>
                    </div>
                </li>

                <li>
                    <a href="#" class="cd-faq-trigger"></a>
                    <div class="cd-faq-content"></div>
                </li>

                <li>
                    <a href="#" class="cd-faq-trigger"></a>
                    <div class="cd-faq-content"></div>
                </li>

            </ul> <!-- cd-faq-group -->
        </div> <!-- cd-faq-items -->
        <a href="#0" class="cd-close-panel">Close</a>
    </section> <!-- cd-faq -->
@endsection