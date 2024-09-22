<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PDF Template</title>

</head>
<style>
	body {
		font-family: Arial, sans-serif;
		margin: 0;
		padding: 0;
		background-color: #fff;
		color: #333;
	}

	.page-break {
		page-break-before: always;
	}

	.main-page {
		max-width: 100%;
		margin: auto;
		padding: 20px;
		box-sizing: border-box;
		background-color: #ffffff;
	}
	.pdf-logo{
		padding:40mm 0px 40mm;
	}

	.pdf-logo, .risk-score-heading, .risk-score-table, .risk-score-graph, .risk-score-dimension, .footer-logo, .contact-details {
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.pdf-logo img, .footer-logo img {
		max-width: 100%;
		height: auto;
	}

	.risk-score .risk-score-heading h2 {
		font-weight: 700;
		text-align: justify;
	}

	.risk-score .risk-score-heading p {
		font-weight: 200;
		font-size: 12px;
		color: #939292;
	}

	.disclaimer, .disclaimer-details, .details {
		max-width: 800px;
		margin: 20px auto;
		text-align: center;
	}

	.disclaimer h4, .disclaimer-details h4 {
		font-style: italic;
		font-weight: 600;
		font-size: 13px;
		color: #5b5959;
		text-align: justify;
	}

	.disclaimer p, .disclaimer-details p {
		font-style: italic;
		font-size: 13px;
		color: #696666;
		letter-spacing: 0.3px;
		text-align: justify;
	}

	.risk-score-table table, .risk-score-details table, .abbreviations-table table {
		width: 100%;
		border-collapse: collapse;
		margin: 20px 0;
	}

	.risk-score-table table td, .risk-score-details table td, .risk-score-details table th, .abbreviations-table table td {
		border: 1px solid #6f6f6f;
		padding: 10px;
		text-align: left;
	}

	.color {
		background-color: #f3f3f3;
	}

	.details ol {
		list-style-position: inside;
		padding-left: 0;
	}

	.details ol li {
		font-size: 15px;
		text-align: justify;
		margin-bottom: 10px;
	}

	.details h4 {
		font-weight: 600;
		font-size: 19px;
		color: #d10a0a;
		margin: 20px 0 10px;
		text-align: justify;
	}

	.pdf-footer {
		padding:10mm 0mm 30mm 0mm;
		text-align: center;
		color: #fff;
	}

	.contact-details {
		max-width: 800px;
		margin: 20px auto;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.social {
		display: flex;
		align-items: center;
		margin: 10px 0;
	}
	.social img{
		height:40px;
		width:auto;
	}
	.social .link {
		margin-left:10px;
	}

	.social .link h3 {
		font-weight: 600;
		font-size: 1.3rem;
		color: #010000;
		margin: 0;
	}

	.social .link p {
		font-size: 14px;
		font-weight: 500;
		color: #514a4a;
		margin: 0;

	}

	@media (max-width: 768px) {
		.pdf-logo img, .footer-logo img {
			height: auto;
			width: 100%;
		}

		.social {
			flex-direction: column;
			align-items: center;
		}

		.social .link {
			margin-left: 0;
			text-align: center;
		}
	}
</style>
<body>  
	<div class="main-page">

		<section class="pdf-logo">
			<img src="https://www.spyderlab.org/assets/account/images/pdf_images/Spyderlab.png"> 
		</section>
		<main>
			<section class="risk-score page-break">
				<div class="risk-score-heading">
					<h2>AML Risk Report</h2>
					<p>Report Generation At {{date('M d,h:i A')}}</p>
				</div>
				<div class="disclaimer">
					<h4>Disclaimer:</h4>
					<p>This Report is for information purpose only and is valid on the date of its issuance. Spyderlab does not give any
						express or implied warranty to the validity of any Report after the date of its’ issuance. Spyderlab takes all steps
						necessary to provide an independent, up-to-date analysis and accurate information in the Report. Spyderlab  is
						not liable for any changes in assumptions and updates to this report in case of new facts or circumstances
						occurring after the date of the Report or facts that were not known to Spyderlab at the time of generation of this
						Report.
					</p>
				</div>
				<div class="risk-score-table">
					<table class="table table-bordered" style="border-color: #6f6f6f;">
						<tr>
							<td class="color">BlockChain</td>
							<td>{{isset($blockcypher['address_details']->currency) ? strtoupper($blockcypher['address_details']->currency) : ''}}</td>
						</tr>
						<tr>
							<td class="color">Wallet Address</td>
							<td>{{$keyword}}</td>
						</tr>
						<tr>
							<td class="color">Sanctions</td>
							<td>No</td>
						</tr>
					</table>
				</div>
				<div style="margin:0mm 20mm 0mm 20mm;" class="risk-score-graph text-center py-2 pt-4">
					<p style="text-align: center;">Risk Score</p>
					{{--<img src="https://www.spyderlab.org/assets/account/images/pdf_images/Aml-risk-score.png">--}}

					@if($chainsight->anti_fraud->credit == 1)
					<img src="https://www.spyderlab.org/assets/account/images/pdf_images/safe.png" alt="" class="mb-2">
					@elseif($chainsight->anti_fraud->credit == 2)
					<img src="https://www.spyderlab.org/assets/account/images/pdf_images/warning.png" alt="" class="mb-2">
					@elseif($chainsight->anti_fraud->credit == 3)
					<img src="https://www.spyderlab.org/assets/account/images/pdf_images/risk.png" alt="" class="mb-2">
					@endif
				</div>

				<div style="margin:0mm 55mm 0mm 55mm;" class="risk-score-dimension text-center py-2 page-break">
					<p style="text-align: center;">Risk dimension</p>

					@if($chainsight->anti_fraud->credit == 1)
					<img src="https://www.spyderlab.org/assets/frontend/images/icons/aml-safe.jpg" alt="" class="mb-2">
					@elseif($chainsight->anti_fraud->credit == 2)
					<img src="https://www.spyderlab.org/assets/frontend/images/icons/aml-warning.jpg" alt="" class="mb-2">
					@elseif($chainsight->anti_fraud->credit == 3)
					<img src="https://www.spyderlab.org/assets/frontend/images/icons/aml-risk.jpg" alt="" class="mb-2">
					@endif

				</div>

				<div class="risk-score-details text-center py-2">
					<p style="text-align: center;">Risk Detail</p>
					<div class="risk-score-details-tabel">
						<div class="table-responsive">
							<table class="table table-bordered" style="border-color: #6f6f6f;">
								<thead>
									<tr>
										<th scope="col" class="py-0">Risk Type</th>
										<th scope="col" class="py-0">Address/Risk Label</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
										@if($chainsight->anti_fraud->credit == 1)
										Safe Address
										@elseif($chainsight->anti_fraud->credit == 2)
										Warning Address
										@elseif($chainsight->anti_fraud->credit == 3)
										Malicious Address
										@endif
										</td>
										<td>{{$keyword}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="details">
					<h3 class="details-heading py-3">Spyderlab Identifies 14 Money Laundering Risk Sources:</h3>
					<h4 class="py-3" style="font-weight: 600; font-size: 19px; color: #d10a0a;">Severe</h4>
					<ol>
						<li  style="text-align:justify;">
							<span style="font-weight: 700;">Sanctions:</span> Sanctioned entities have been legally penalized, usually by international
							bodies or governments. These sanctions often occur due to a variety of violations,
							including involvement in money laundering or other financial crimes.
						</li>

						<li  style="text-align:justify;">
							<span style="font-weight: 700;">Illicit Coins:</span>These are coins acquired through illicit means, such as theft, scam,
							ransom, or the deployment of malicious software (malware).                        
						</li>

						<li  style="text-align:justify;">
							<span style="font-weight: 700;">Terrorism Financing:</span> This category includes any entities that have been linked to
							financing terrorism, a practice that often involves complex and hidden financial networks
							to evade detection.
						</li>
						<!-- heading -->
						<h4 class="py-3" style="font-weight: 600; font-size: 19px; color: #d10a0a; margin-left: -25px;">High-Risk</h4>

						<li style="text-align:justify;">
							<span style="font-weight: 700;">Coin Mixer:</span> Coin mixers operate by blending cryptocurrency funds with others, making
							it nearly impossible to trace the origin of the coins. This layer of anonymity provides an
							opportunity for money laundering, as it obstructs tracking and tracing measures that law
							enforcement agencies might use to detect illegal activities.
						</li>
						<li style="text-align:justify;">
							<span style="font-weight: 700;">Risky Exchange:</span> An entity becomes high-risk based on the following criteria:
						</li>
						<ul>
							<li style="padding: 10px;text-align:justify;">No KYC: The entity does not require or verify any customer information before
							authorizing deposits or withdrawals.</li>
							<li style="padding: 10px;text-align:justify;">Criminal Connections: The legal entity has been charged in connection with AntiMoney Laundering/Combating the Financing of Terrorism (AML/CFT) violations.</li>
							<li style="padding: 10px;text-align:justify;">Unlicensed: The entity lacks a specific license to trade cryptocurrencies.</li>
							<li style="padding: 10px;text-align:justify;">Resisting Law Enforcement Requests: The entity fails to respond to any law enforcement requests.</li>
						</ul>
						<li style="text-align:justify;">
							<span style="font-weight: 700;">Darknet Market:</span> : These markets operate within the 'darknet', a part of the internet that
							is intentionally hidden and inaccessible through standard web browsers. Here, coins
							may be used in exchange for illicit goods and services, creating high-risk associations.
						</li>

						<li style="text-align:justify;">
							<span style="font-weight: 700;">Illegal Services/Platforms:</span> These are platforms or services involved in illegal activities
							like Ponzi schemes or investment scams, which are fraudulent investment operations
							that generate returns for early investors with money taken from later investors.
						</li>
						<li style="text-align:justify;">
							<span style="font-weight: 700;">Public Freezing Actions:</span> This refers to coins frozen by respected entities. Large
							stablecoin projects like Tether or Circle often have the ability to freeze funds to prevent
							illegal activities, adding to the risk factor of these coins.

						</li>
						<!-- heading -->
						<h4 class="py-3" style="font-weight: 600; font-size: 19px; color: #d10a0a; margin-left: -25px;">Medium-Risk</h4>

						<li style="text-align:justify;">
							<span style="font-weight: 700;">Gambling: </span>: Involves funds associated with unlicensed online games or gambling
							platforms.
						</li>
						<li style="text-align:justify;">
							<span style="font-weight: 700;">Centralized Bridge:</span> These are entities that act as bridges, enabling the transfer of
							funds between different blockchains. This ability to move assets without trading them on
							an exchange creates a risk of misuse.
						</li>
						<li style="text-align:justify;">
							<span style="font-weight: 700;"> Privacy Protocol: </span> These are protocols or entities that employ privacy features, such as
							zero-knowledge proofs. While these features offer users privacy, they can also obscure
							the transparency of transactions and hide the addresses of counterparties, increasing
							the risk of money laundering.
						</li>
						<!-- heading -->
						<h4 class="py-3" style="font-weight: 600; font-size: 19px; color: #d10a0a; margin-left: -25px;">Low-Risk</h4>

						<li style="text-align:justify;">
							<span style="font-weight: 700;">DEX:</span>The blockchain application that facilitates cryptocurrency and token trading
							through automated smart contracts. Trades on the decentralized platform are peer-topeer and have no third party or central authority other than the smart contract that
							executes the trades, making it a popular money laundering tool among malicious actors.
						</li>
						<li style="text-align:justify;">
							<span style="font-weight: 700;"> DeFi Protocol:</span> Decentralized finance (DeFi) is an emerging financial technology that
							challenges the current centralized banking system, it allows users to peer-to-peer lend
							and borrow crypto assets peer-to-peer without interacting with a third party or central
							authority.
						</li>
						<li style="text-align:justify;">
							<span style="font-weight: 700;">NFT Marketplace:</span> Assemblages of NFTs on platforms dedicated to their issuance,
							trade, and sale. Classified by their real-world purpose, despite similarities to smart
							contracts or decentralized exchanges
						</li>
					</ol>
				</div>

				<div class="abbreviations-table page-break">
					<table class="table table-bordered" style="border-color: #6f6f6f;">
						<tr>
							<td class="color">AML</td>
							<td>Anti-money Laundering</td>
						</tr>
						<tr>
							<td class="color"><A>ATM</A></td>
							<td>Automated taller Machine</td>
						</tr>
						<tr>
							<td class="color">CDD</td>
							<td>Customer Due Diligence</td>
						</tr>
						<tr>
							<td class="color">CFT</td>
							<td>Counter Financing of Terrorism </td>
						</tr>
						<tr>
							<td class="color">FATF</td>
							<td>Financial Action Task Force</td>
						</tr>
						<tr>
							<td class="color">FINTECH</td>
							<td>Financial Technology</td>
						</tr>
						<tr>
							<td class="color">FIU</td>
							<td>Financial Intelligence Unit</td>
						</tr>
						<tr>
							<td class="color">LOCTA</td>
							<td>Internet Organized Crime Treat Assessment</td>
						</tr>
						<tr>
							<td class="color">KYC</td>
							<td>Know Your Customer</td>
						</tr>
						<tr>
							<td class="color">NGO</td>
							<td>Non-Governmental Organization ML Money Laundering</td>
						</tr>
						<tr>
							<td class="color">PEP</td>
							<td>Politically Exposed Person</td>
						</tr>
						<tr>
							<td class="color">PSP</td>
							<td>Payment Service Provider</td>
						</tr>
						<tr>
							<td class="color">STR</td>
							<td>Suspicious Transaction Report</td>
						</tr>
						<tr>
							<td class="color">TF</td>
							<td>Terrorist Financing</td>
						</tr>
					</table>
				</div>

				<div class="disclaimer-details py-4">
					<h4>Disclaimer:</h4>
					<p>This Report is for information purpose only and is valid on the date of its issuance. Spyderlab
						does not give any express or implied warranty to the validity of any Report after the date of its’
						issuance. Spyderlab takes all steps necessary to provide an independent, up-to-date analysis
						and accurate information in the Report. spyderlab is not liable for any changes in assumptions
						and updates to this report in case of new facts or circumstances occurring after the date of the
						Report or facts that were not known to Spyderlab at the time of generation of this Report.
					</p>
				</div>
			</section>
			<section class="pdf-footer">
				<div class="footer-logo text-center">
					<img src="https://www.spyderlab.org/assets/account/images/pdf_images/Spyderlab.png" style="width:auto; height:200px;">
					<p style="color:; padding: 10px;">A Crypto tracking and Compliance Platform for Everyone</p>
				</div>

				<div class="contact-details">
					<div class="social">
						<a target="_blank" href="https://www.spyderlab.org"><img src="https://www.spyderlab.org/assets/account/images/pdf_images/world-globe.png"></a>
						<div class="link">
							<h3>Official Website</h3>
							<p><a target="_blank" style="text-decoration:none;color:#514a4a;" href="https://www.spyderlab.org">Spyderlab.org</a></p>
						</div>

					</div>
					<div class="social">
						<a target="_blank" href="https://www.t.me/spyderlab"><img src="https://www.spyderlab.org/assets/account/images/pdf_images/telegram.png"></a>
						<div class="link">
							<h3>Telegram</h3>
							<p><a target="_blank" style="text-decoration:none;color:#514a4a;" href="https://www.t.me/spyderlab">@spyderlab</a></p>
						</div>

					</div>
					<div class="social">
						<img src="https://www.spyderlab.org/assets/account/images/pdf_images/gmail.png">
						<div class="link">
							<h3>Email</h3>
							<p>info@spyderlab.org</p>
						</div>
					</div>
				</div>
			</section>
		</main>
	</div>
</body>
</html>
