@extends('frontend.layouts.app')


@section('og')
<title>{{ (!empty($seoData->title) && !empty($seoData)) ? $seoData->title : (settings('site')->meta_title ?? config('app.name')) }}</title>
<meta name="title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}">
<meta name="description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="keywords" content="{{ ( !empty($seoData) && !empty($seoData->meta_keyword)) ? $seoData->meta_keyword : (settings('site')->meta_keywords ?? '') }}">
<meta name="author" content="Osint">
<meta name="robots" content="index follow" />
<link rel="canonical" href="{{url()->current()}}"/>
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}" />
<meta property="og:description" content="{{ (!empty($seoData) && !empty($seoData->meta_des) ) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}" />
<meta property="og:url" content="{{url()->current()}}"/>
<meta property="og:image" content="{{ !empty($seoData) ?  getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}" />
<meta property="og:image:width" content="850">
<meta property="og:image:height" content="560">
<meta property="og:site_name" content="spyderlab" />
<meta property="og:locale" content="en" />
<meta property="twitter:url" content="{{url()->current()}}">
<meta property="twitter:image" content="{{ !empty($seoData) ? getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}">
<meta property="twitter:title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}">
<meta property="twitter:description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="twitter:description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="twitter:image" content="{{ !empty($seoData) ? getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}">
<meta name="twitter:card" value="summary_large_image">
<meta name="twitter:site" value="@spyderlab">
@endsection

@section('content')
    <main>
        <section class="section-home py-5">
            <div class="container-xl container-fluid">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-12">
                        <nav>
                            <ol class="breadcrumb justify-content-center mb-3 text-light">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Terms of Service</li>
                            </ol>
                        </nav>
                        <h1 class="fs-2 mb-0">Terms of Service</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-custom-light py-5">
            <div class="container-xl container-fluid">
                <div class="row justify-content-center align-items-center text-justify">
                    <div class="col-md-12">
                        <p>Spyderlab (“Spyder”, “Spyderlab.org”, “we”, “us” and terms of similar meaning) provides this website, and the services provided by or through this website to you are subject to these terms of use (these “Terms”). Using Spyderlab signifies your agreement to these Terms, which may be updated by Spyderlab from time to time without prior notice.</p>
                        <p>There is a strict prohibition on submitting illegal information or files. Ensure that your data does not constitute a violation of any law or can be construed as such. You may be terminated from Spyderlab at any time, without prior notice, and at the sole discretion of Spyderlab, if you fail to comply.</p>
                        <p>Spyderlab’s services are strictly for law enforcement agencies/officers' use only. If you want to use the services of Spyderlab, please contact us here <a href="https://www.spyderlab.org/contact-us" target="_blank" title="Spyderlab" class="fw-bold custom-link">https://www.spyderlab.org/contact-us</a> or mail to <a href="mailto:spyd3rlab@gmail.com" class="fw-bold custom-link">spyd3rlab@gmail.com</a>.</p>
                        <p>You are prohibited from-</p>
                        <ul>
                            <li>Using Spyderlab's search results in an application that has not been approved by Spyderlab. Especially third-party applications, mobile applications, or search applications;</li>
                            <li>Publishing or copying the Spyderlab search results in any form in any interface besides the Spyderlab interface unless Spyderlab expressly authorizes you to do so;</li>
                            <li>Using Spyderlab in an unauthorized manner that could interfere with anyone else's use.</li>                            
                        </ul>
                        <p>Spyderlab will not tolerate automated searches via search scripts and will block your IP address and/or terminate your account if you do so. Google Privacy Policy and Terms of Service apply to this site, which is protected by reCAPTCHA.</p>
                        <p>Data uploaded to Spyderlab are not made accessible to any other users. Copyright for all information submitted to Spyderlab remains with the original owner/author.</p>
                        <p>Spyderlab search results link to third-party websites that are not owned or controlled by Spyderlab. A third-party website's content, privacy policies, or practices are not the responsibility of Spyderlab.</p>
                        <p>Spyderlab may earn a commission if you click on a link to a third-party website and make a purchase. This type of link is always clearly labeled as "sponsored." Sponsored links contain an affiliate code that informs the destination website that the traffic came from Spyderlab. Neither the information you searched for nor any personal information about you is shared with third parties.</p>
                        <p>MEMBERSHIP WILL BE TERMINATED IF FRAUD IS ATTEMPTED OR COMMISSIONS WILL BE VOIDED IF FRAUD IS COMMITTED.</p>
                        <hr>

                        <h2 class="fs-4">Disclaimer of Any Warranty</h2>
                        <p>SOCIAL NETWORKS' OPEN SEARCH API IS USED TO FETCH REAL-TIME SEARCH RESULTS WHICH ARE NOT CENSORED. HOWEVER, WE NEITHER REPRESENT NOR WARRANT THAT SPYDERLAB IS FREE OF ERRORS, BUGS, OR INTERRUPTIONS, OR THAT IT IS ACCURATE, COMPLETE, OR RELIABLE.</p>
                        <p>SPYDERLAB IS PROVIDED "AS IS" WITH NO WARRANTY OF ANY KIND, EXCLUSIVE OR IMPLIED, AND WE EXPRESSLY DISCLAIM ALL WARRANTIES AND CONDITIONS, INCLUDING, BUT NOT LIMITED TO, ANY IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AVAILABILITY, SECURITY, TITLE AND/OR NON-INFRINGEMENT.</p>
                        <p>YOU AGREE TO USE SPYDERLAB AT YOUR OWN DISCRETION AND RISK, AND TO BEAR SOLE RESPONSIBILITY FOR ANY DAMAGE CAUSED TO YOUR COMPUTER SYSTEM OR DATA LOSS THAT MAY RESULT FROM THE USE OF SPYDERLAB.</p>

                        <hr>

                        <h2 class="fs-4">Limitation of Liability</h2>
                        <p>WE SHALL NOT, UNDER ANY CIRCUMSTANCES, BE LIABLE TO YOU FOR ANY INDIRECT, INCIDENTAL, CONSEQUENTIAL, SPECIAL, OR EXEMPLARY DAMAGES ARISING OUT OF OR IN CONNECTION WITH THE USE OF SPYDERLAB, WHETHER BASED ON BREACH OF CONTRACT, BREACH OF WARRANTY, TORT (INCLUDING NEGLIGENCE, PRODUCT LIABILITY OR OTHERWISE), OR ANY OTHER PECUNIARY LOSS, WHETHER OR NOT WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. FURTHERMORE, WE CANNOT BE HELD RESPONSIBLE FOR THIRD-PARTY ADVERTISEMENTS.</p>
                        <p>SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF CERTAIN WARRANTIES OR THE LIMITATION OR EXCLUSION OF LIABILITY FOR INCIDENTAL OR CONSEQUENTIAL DAMAGES. ACCORDINGLY, SOME OR ALL OF THE ABOVE EXCLUSIONS OR LIMITATIONS MAY NOT APPLY TO YOU, AND YOU MAY HAVE ADDITIONAL RIGHTS.</p>

                        <hr>

                        <h2 class="fs-4">User-contributed Content</h2>
                        <p>Each member of Spyderlab.org retains the copyright on the materials they contribute.</p>
                        <p>Unless otherwise stated, all text, files, images, graphics, photos, audio clips, sounds, video, or other materials (the "Content") posted on, transmitted through, or linked from the Site are the sole responsibility of the person from whom they originated. All Content, whether posted, emailed, or otherwise uploaded to the Site, is the sole responsibility of the person posting, emailing, or otherwise uploading it. In the event that you provide any content to Provider, you agree to indemnify it as follows.</p>
                        <p>The Content you post on the Site represents and warrants that:</p>
                        <p>(i) the content you provide is yours, and you have all the rights to use it as described in this Terms of Service, including but not limited to copyrights;
                        <br>(ii) you are providing true, accurate, current, and complete information; and,<br>(iii) you won't harm any person or entity; (iv) no pornographic, hate-related, violent, or illegal content is included.</p>

                        <hr>

                        <h2 class="fs-4">Release And Waiver</h2>
                        <p>In accordance with applicable law, you hereby release and waive all claims against Spyderlab as well as its subsidiaries, affiliates, officers, agents, licensers/licensors, co-branders, and employees from any and all claims, damages (actual and/or consequential), costs and expenses (including litigation costs and attorneys' fees) arising from or in any way related to Spyderlab’s use. To the fullest extent permitted by law, you waive and relinquish any rights and benefits you may have under any similar law principles.</p>

                        <hr>

                        <h2 class="fs-4">General Terms</h2>
                        <p>It is unrestricted for us to disclose aggregate as well as non-identifying information about our customers. Our privacy policy describes how we may disclose personally identifiable information we collect or that you provide:</p>
                        <ul>
                            <li><strong class="fw-bold">Invalidity of Specific Terms:</strong> In the event that any provision of the Terms of Service is deemed invalid by a court of competent jurisdiction, the parties agree that the court should make every effort to give effect to the parties' intentions as reflected in the provision and that the other provisions of the documents remain valid.</li>
                            <li><strong class="fw-bold">Lawsuit Location and Choice of Law:</strong> Your relationship with Spyderlab is governed by the laws of the Province of the United States, without regard to conflicts of law. Spyderlab and you agree to submit to the jurisdiction of the United States courts.</li>
                            <li><strong class="fw-bold">No Waiver of Rights by Spyderlab:</strong> This Terms of Service does not constitute a waiver of any right or provision of Spyderlab.</li>
                        </ul>

                        <hr>

                        <h2 class="fs-4">Cookies Policy</h2>
                        <p>In this Cookie Policy, we describe how Spyderlab sets and reads cookies when you navigate our website.</p>
                        <h3 class="fs-5">What Is A Cookie?</h3>
                        <p>"An HTTP cookie is a small piece of data sent from a website and stored on the user's computer by the user's web browser while the user is browsing. Cookies were designed to be a reliable mechanism for websites to remember stateful information" – Wikipedia.</p>
                        <p>A cookie allows the website to remember your actions and preferences (such as language, font size, and other display preferences) over time, so you don't have to re-enter them every time you visit the site.</p>
                        <p>Cookies can be set and read by the website itself or by authorized third-party websites. A temporary or persistent cookie can also be used. The term "temporary cookie" refers to a cookie that is only used for that particular session. Cookies that are persistent remain in your browser's cookie file for longer periods of time, depending on their lifespan. Personal information can be associated with cookies because they are unique identifiers.</p>
                        <h3 class="fs-5">How Spyderlab Uses Cookies?</h3>
                        <p>By analyzing and optimizing the way the website works on desktop, tablet, and mobile devices, Spyderlab uses cookies to optimize the user experience.</p>
                        <p>The full list of cookie use cases is as follows:</p>
                        <ul>
                            <li><strong class="fw-bold">User Preferences:</strong> Cookies keep track of your preferences (like your language preference or country location). Our cookies enable you to log in and access our services more easily, which makes your user experience more consistent and convenient.</li>
                            <li><strong class="fw-bold">Analytical Tools:</strong> Third-party cookies are used to analyze our website. This helps us determine which content is helpful to you and which pages are more relevant to you.</li>
                            <li><strong class="fw-bold">Marketing:</strong> Third-party cookies, such as those from Google, allow us to show you targeted advertisements.</li>
                        </ul>
                        <hr>

                        <h2 class="fs-4">Contact</h2>
                        <p>For any questions or comments, you may contact us here <a href="https://www.spyderlab.org/contact-us" target="_blank" title="Spyderlab" class="fw-bold custom-link">https://www.spyderlab.org/contact-us</a> or by direct mail at <a href="mailto:spyd3rlab@gmail.com" class="fw-bold custom-link">spyd3rlab@gmail.com</a>. </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
   @endsection