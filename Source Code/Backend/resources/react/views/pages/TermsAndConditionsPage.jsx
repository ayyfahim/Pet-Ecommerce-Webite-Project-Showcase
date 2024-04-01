/* eslint-disable react-hooks/exhaustive-deps */
import React from "react";
import { connect } from "react-redux";
import { Container, Row, Col } from "react-bootstrap";

export const TermsAndConditionsPage = props => {
    const { pageTitle } = props;

    return (
        <>
            <section className="section bg-white py-5 h-100">
                <Container>
                    <Row>
                        <Col xs={{ span: 12 }}>
                            <h1 className="h3 font-weight-bold text-capitalize mb-0">{pageTitle}</h1>
                        </Col>
                        <Col xs={{ span: 12 }} className="mt-4">
                            <Row>
                                <Col xs={{ span: 12 }}>
                                    <section className="section static-page-content-section">
                                        <Row>
                                            <Col xs={{ span: 12 }}>
                                                <h4 className="text-primary">Scope</h4>
                                                <ol>
                                                    <li>
                                                        <div>
                                                            <h6>Introduction</h6>
                                                            <p>
                                                                This website is owned and operated by Deal A Day Limited ("we","us", "our"). These Terms of Use constitute an agreement made between the
                                                                website user ("you", "your") and us. You must not access or use this website unless you accept all of these Terms of Use. By accessing
                                                                and using this website you confirm your acceptance of these Terms of Use.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Other documents</h6>
                                                            <p>
                                                                Where we collect your personal information as a result of your accessing and using this website, our Privacy Policy will apply to that
                                                                information. Accordingly, these Terms of Use must be read in con junction with our Privacy Policy.
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ol>
                                                <br />
                                                <br />
                                                <br />
                                                <h4 className="text-primary">Your obligations</h4>
                                                <ol>
                                                    <li>
                                                        <div>
                                                            <h6>Restrictions</h6>
                                                            <p>
                                                                You must not access or use this website other than in accordance with these Terms of Use. In the course of accessing and using this
                                                                website, you must not
                                                            </p>
                                                            <ol type="a">
                                                                <li>
                                                                    <p>Disrupt or interfere with this website, or any other software, hardware or network associated with this website;</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        Use simultaneous,unattended, or continuous connections to this website or otherwise use this website in a manner that advertise
                                                                        effects the availability of its resources to other users;
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        Send unsolicited electronic messages or to otherwise harass,threaten, abuse, embarrass, or cause distress, unwanted attention,
                                                                        or harm to any person;
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        Transmit any files or material of any kind which contain a virus, corrupted data,or other malicious code ( whether via this
                                                                        website or in any email that you send to us);
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        Reproduce any part of this website without our prior written permission, which we may withhold or grant (on terms acceptable to
                                                                        us), in our absolute discretion;
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        Gain, or attempt to gain, unauthorized access to any part of this website, any other computer system, or any email or other
                                                                        private message not intended for you;
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>Infringe, or attempt to infringe, the intellectual property rights of any person;</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        Submit any material for publication that is offensive, defamatory or inappropriate; or violate any laws, rules, or regulations
                                                                        applying to or relating to your access to or use of this website.
                                                                    </p>
                                                                </li>
                                                            </ol>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Your account</h6>
                                                            <p>
                                                                We may create an account for you (including a username and password) to verify your identity when you use this website. Your username
                                                                and password are personal to you and you must at all times maintain the confidentiality of your username and password and not disclose
                                                                them to any third party. You agree that you are solely responsible for any use of this website by any person using your username and
                                                                password and you agree to indemnify us against any and all claims arising out of your failure to maintain the confidentiality of your
                                                                username or password.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Indemnity</h6>
                                                            <p>
                                                                You will indemnify us, our officers and employees from and against all claims, demands, damages,losses, costs, and expenses arising
                                                                from:
                                                            </p>
                                                            <ol type="a">
                                                                <li>
                                                                    <p>your access to, use of, or reliance upon any part of this website;</p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        you (or any other person permitted by you) using, copying, modifying,publishing, or distributing any part of this website; any
                                                                        breach by you of any of these Terms of Use;
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>And your negligent or wilful acts or omissions in accessing or using this website.</p>
                                                                </li>
                                                            </ol>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Returns & refunds</h6>
                                                            <p>
                                                                We will honour our obligations under the Consumer Guarantees Act 1993. However, we will not provide refunds or accept returns where you
                                                                have changed your mind.
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ol>
                                                <br />
                                                <br />
                                                <br />
                                                <h4 className="text-primary">Content, Availability, and Security</h4>
                                                <ol>
                                                    <li>
                                                        <div>
                                                            <h6>Availability</h6>
                                                            <p>
                                                                Your use of this website and any associated services may sometimes be subject to interruption or delay. Due to the nature of the
                                                                Internet and electronic communications, we and our service providers do not make any warranty that this website or any associated
                                                                services will be error free,without interruption or delay, or free from defects in design. We will not be liable for any damages or
                                                                refunds should this website become inter rupted or delayed for any reason.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Errors</h6>
                                                            <p>
                                                                While we endeavour to ensure that the content of this website is free from errors, we do not give any warranty or other assurance as to
                                                                the content of material appearing on this website, its accuracy, completeness, timeliness or fitness for any particular purpose. We make
                                                                no warranty that products ordered from us will meet your requirements and you should therefore ensure that the products you order will
                                                                be suitable for your purposes.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Outbound hyperlinks</h6>
                                                            <p>
                                                                This website may contain hyperlinks to third party websites ("outbound hyperlinks"). Outbound hyperlinks are provided for your
                                                                convenience only and may not remain current or be maintained. We make no endorsement of, and accept no responsibility for, any content
                                                                accessible through any outbound hyperlink. You are responsible for complying with any terms and conditions imposed by third party
                                                                websites.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Inbound hyperlinks</h6>
                                                            <p>
                                                                You agree that you will not publish or distribute any hyperlinks to this website ("inbound hyperlinks") without our prior written
                                                                permission in each instance.If you do create an inbound hyperlink, you will be responsible for all losses (whether direct or indirect)
                                                                that we may suffer as a result of that hyperlink. Publishing or distributing inbound hyperlinks is done at your own risk.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Malicious code</h6>
                                                            <p>
                                                                Although we endeavour to take reasonable steps to prevent the introduction of viruses or other malicious code (together, "malicious
                                                                code") to this website, we do not guarantee or warrant that this website, or any data available from it, does not contain malicious
                                                                code. We will not be liable for any damages or harm attributable to malicious code. You are responsible for ensuring that the process
                                                                that you employ for accessing this website does not expose your computer system to the risk of interference or damage from malicious
                                                                code.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Security</h6>
                                                            <p>
                                                                Although we endeavour to protect the security of your personal information, including credit card information, you acknowledge that
                                                                there is a risk of unauthorised access to or alteration of your transmissions or data or of the information contained on your computer
                                                                system or on this website. We do not accept responsibility or liability of any nature for any losses that you may sustain as a result of
                                                                such unauthorised access or alteration. All information transmitted to you or from you is transmitted at your risk. We do not accept
                                                                responsibility for any interference or damage to your own computer system which arises in connection with your accessing of this website
                                                                or any outbound hyperlink.
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ol>
                                                <br />
                                                <br />
                                                <br />
                                                <h4 className="text-primary">Intellectual Property</h4>
                                                <ol>
                                                    <li>
                                                        <div>
                                                            <h6>Our intellectual property</h6>
                                                            <p>
                                                                The information and products displayed on this website are protected by copyright and other laws of New Zealand, and under similar laws
                                                                and international conventions abroad. You acknowledge and agree that all copyright and other intellectual property rights that may
                                                                subsist in the information and products displayed on this website, including text,illustrations, photographs, layout, designs
                                                                (including, in particular, product designs and detailing) belong to us or to our licensors (together, "our intellectual property"). Any
                                                                information that you submit to this website for publication (including without limitation product reviews and postings on user forums)
                                                                becomes our property and you relinquish all proprietary rights you have in such information.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Our trade marks</h6>
                                                            <p>
                                                                You acknowledge and agree that any trade marks appearing on this website belong to us or to our licensors. You are not permitted to use
                                                                or reproduce (or allow anyone to use or reproduce) those trade marks for any reason except with the prior written consent of the trade
                                                                mark owner.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Outbound hyperlinks</h6>
                                                            <p>
                                                                This website may contain hyperlinks to third party websites ("outbound hyperlinks"). Outbound hyperlinks are provided for your
                                                                convenience only and may not remain current or be maintained. We make no endorsement of, and accept no responsibility for, any content
                                                                accessible through any outbound hyperlink. You are responsible for complying with any terms and conditions imposed by third party
                                                                websites.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Infringement</h6>
                                                            <p>
                                                                You must not copy, distribute,resupply, sell, prepare of derivative works from, or otherwise deal with our intellectual property except
                                                                with our prior written consent in each instance. We value our intellectual property rights and will vigorously enforce those rights to
                                                                the fullest extent permitted by law.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Limited permission to use</h6>
                                                            <p>
                                                                You may view,download, or print a single page of this website for your own personal, non-commercial use. You must not otherwise print or
                                                                reproduce any part of this website for any reason except with our prior written consent in each instance. By making this website
                                                                available to you, we do not give you any other right, title,interest, or licence in or to any of our intellectual property.
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ol>
                                                <br />
                                                <br />
                                                <br />
                                                <h4 className="text-primary">Warranties and liability</h4>
                                                <ol>
                                                    <li>
                                                        <div>
                                                            <h6>Warranties</h6>
                                                            <p>
                                                                To the maximum extent permitted by law, we disclaim all warranties, representations, and guarantees(whether, express, implied, or
                                                                statutory), with respect to any product or any information supplied to you by us including, but not limited to, warranties of
                                                                merchantability or fitness for a particular purpose.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Consumer Guarantees Act</h6>
                                                            <p>
                                                                Nothing in these Terms of Use is intended to avoid the provisions of the Consumer Guarantees Act 1993 except to the extent permitted by
                                                                that Act, or to exclude liability arising under any other statute, if and to the extent that such liability cannot be lawfully excluded,
                                                                and these Terms of Use shall be modified to the extent necessary to give effect to that intention. If you are acquiring goods or
                                                                services for the purposes of a business you agree that the guarantees provided in the Consumer Guarantees Act 1993 shall not apply.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Right to access and request correction</h6>
                                                            <p>
                                                                You may contact our Privacy Officer to request access to, or correction of, any personal information we hold about you by contacting us.
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ol>
                                                <br />
                                                <br />
                                                <br />
                                                <h4 className="text-primary">General</h4>
                                                <ol>
                                                    <li>
                                                        <div>
                                                            <h6>Changes</h6>
                                                            <p>
                                                                We reserve the right to change these Terms of Use from time to time by publishing the changed Terms of Use on this website. By
                                                                continuing to access and use this website following such publication, you confirm your acceptance of these Terms of Use as revised. We
                                                                reserve the right to modify or remove (at any time and without notice to you) any information, product, product specification, or any
                                                                other part of this website.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Electronic Communications</h6>
                                                            <p>
                                                                You consent to receiving communications from us electronically and you agree that all agreements, notices, disclosures and other
                                                                communications that we provide to you electronically satisfy any legal requirement that such communications be in writing. You agree to
                                                                be bound by any agreement reached through electronic communications in terms of the Electronic Transactions Act 2002. You can stop
                                                                receiving communications from us electronically by emailing us and by clicking on an unsubscribe link on our email. You can also
                                                                unsubscribe by clicking on link in the footer.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Severability</h6>
                                                            <p>
                                                                If any provision of these Terms of Use is held to be invalid or unenforceable for any reason, the remaining provisions shall, to the
                                                                maximum extent possible, remain in full force and effect.
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6>Governing Law</h6>
                                                            <p>
                                                                These Terms of Use shall be governed by the laws of New Zealand and the courts of New Zealand shall have non-exclusive jurisdiction to
                                                                hear and determine any dispute arising in relation to these Terms of Use. Except as otherwise described, all materials on this website
                                                                are made available only to provide information about us, this website, and the products which may be ordered from this website. This
                                                                website has been prepared in accordance with New Zealand law, and may not satisfy the laws of any other country. We make no
                                                                representations or warranties as to whether or not the information or products available from this website are appropriate or available
                                                                for use in other countries. If you choose to access this website from outside New Zealand you are responsible for compliance with
                                                                applicable local law
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </Col>
                                        </Row>
                                    </section>
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </Container>
            </section>
        </>
    );
};

const mapStateToProps = state => ({ ...state });
const mapDispatchToProps = dispatch => ({});

export default connect(mapStateToProps, mapDispatchToProps)(TermsAndConditionsPage);
