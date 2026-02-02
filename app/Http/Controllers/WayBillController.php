<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Waybill;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SoapClient;

class WayBillController extends Controller
{
    // ავტორიზირებული ქვემომხმარებლის მონაცემები (ქვემომხმარებელი)
    public function checkuser()
    {
        $wsdl = 'https://services.rs.ge/WayBillService/WayBillService.asmx?wsdl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        $client = new SoapClient($wsdl, $options);

        //            rs-01017050601
        //            286241
        $params = [
            'su' => 'DEVELOPER:01024064358',
            'sp' => 'Alaverda18$',
        ];

        $response = $client->__soapCall('chek_service_user', [$params]);

        return $response;
    }

    // ყველა ქვემომხმარებლის გამოტანა (მთავარი მომხმარებელი)
    public function getServiceUsers(Request $request)
    {
        $wsdl = 'https://services.rs.ge/WayBillService/WayBillService.asmx?wsdl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        try {
            $client = new SoapClient($wsdl, $options);

            //            rs-01017050601
            //            286241
            //            $params = [
            //                'user_name'     => '01024064358',
            //                'user_password' => '31101410',
            //            ];

            $params = [
                'user_name' => 'tbilisi',
                'user_password' => '123456',
            ];

            $response = $client->__soapCall('get_service_users', [$params]);

            $xml_string = $response->get_service_usersResult->any;

            if ($xml_string) {
                $xml_object = simplexml_load_string($xml_string);

                if ($xml_object === false) {
                    echo 'Failed to parse XML.';
                    foreach (libxml_get_errors() as $error) {
                        echo $error->message;
                    }
                } else {
                    $json_string = json_encode($xml_object);

                    $array = json_decode($json_string, true);

                    return $array;
                    //                    print_r($array);

                }
            } else {
                echo 'No data found.';
            }
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // ზედნადების ტიპები (ქვემომხმარებელი)
    public function gettypes(Request $request)
    {
        $wsdl = 'https://services.rs.ge/WayBillService/WayBillService.asmx?wsdl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        try {
            $client = new SoapClient($wsdl, $options);

            $params = [
                'su' => 'developer:01024064358',
                'sp' => 'Alaverda18$',
            ];

            $response = $client->__soapCall('get_waybill_types', [$params]);

            //           return $response;

            $xml_string = $response->get_waybill_typesResult->any;

            if ($xml_string) {
                $xml_object = simplexml_load_string($xml_string);

                if ($xml_object === false) {
                    echo 'Failed to parse XML.';
                    foreach (libxml_get_errors() as $error) {
                        echo $error->message;
                    }
                } else {
                    $json_string = json_encode($xml_object);

                    $array = json_decode($json_string, true);

                    return $array;
                }
            } else {
                echo 'No data found.';
            }
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getTransTypes(Request $request)
    {
        $wsdl = 'https://services.rs.ge/WayBillService/WayBillService.asmx?wsdl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        try {
            $client = new SoapClient($wsdl, $options);

            $params = [
                'su' => 'developer:01024064358',
                'sp' => 'Alaverda18$',
            ];

            $response = $client->__soapCall('get_trans_types', [$params]);

            //           return $response;

            $xml_string = $response->get_trans_typesResult->any;

            if ($xml_string) {
                $xml_object = simplexml_load_string($xml_string);

                if ($xml_object === false) {
                    echo 'Failed to parse XML.';
                    foreach (libxml_get_errors() as $error) {
                        echo $error->message;
                    }
                } else {
                    $json_string = json_encode($xml_object);

                    $array = json_decode($json_string, true);

                    return $array;
                }
            } else {
                echo 'No data found.';
            }
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // ზომის ერთეულები (ქვემომხმარებელი)
    public function getunits()
    {
        $wsdl = 'https://services.rs.ge/WayBillService/WayBillService.asmx?wsdl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        try {
            $client = new SoapClient($wsdl, $options);

            $params = [
                'su' => 'developer:01024064358',
                'sp' => 'Alaverda18$',
            ];

            $response = $client->__soapCall('get_waybill_units', [$params]);

            //           return $response;

            $xml_string = $response->get_waybill_unitsResult->any;

            if ($xml_string) {
                $xml_object = simplexml_load_string($xml_string);

                if ($xml_object === false) {
                    echo 'Failed to parse XML.';
                    foreach (libxml_get_errors() as $error) {
                        echo $error->message;
                    }
                } else {
                    $json_string = json_encode($xml_object);

                    $array = json_decode($json_string, true);

                    return $array;
                }
            } else {
                echo 'No data found.';
            }
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // შეცდომის კოდები (ქვემომხმარებელი)
    public function geterror(Request $request)
    {
        $wsdl = 'https://services.rs.ge/WayBillService/WayBillService.asmx?wsdl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        try {
            $client = new SoapClient($wsdl, $options);

            //            rs-01017050601
            //            286241
            $params = [
                'su' => 'developer:01024064358',
                'sp' => 'Alaverda18$',
            ];

            $response = $client->__soapCall('get_error_codes', [$params]);

            $xml_string = $response->get_error_codesResult->any;

            if ($xml_string) {
                $xml_object = simplexml_load_string($xml_string);

                if ($xml_object === false) {
                    echo 'Failed to parse XML.';
                    foreach (libxml_get_errors() as $error) {
                        echo $error->message;
                    }
                } else {
                    $json_string = json_encode($xml_object);

                    $array = json_decode($json_string, true);

                    return $array;
                    //                    print_r($array);

                }
            } else {
                echo 'No data found.';
            }
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // კონკრეტული ზედნადების გამოტანა აიდის მიხედვით (ქვემომხმარებელი)
    public function getinvoice()
    {
        $wsdl = 'https://services.rs.ge/WayBillService/WayBillService.asmx?wsdl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        $client = new SoapClient($wsdl, $options);

        //            rs-01017050601
        //            286241
        $params = [
            'su' => 'DEVELOPER:01024064358',
            'sp' => 'Alaverda18$',
            'waybill_id' => 888166349,
        ];

        $response = $client->__soapCall('get_waybill', [$params]);

        //        return $response;
        $xml_string = $response->get_waybillResult->any;
        $xml_object = simplexml_load_string($xml_string);
        $json_string = json_encode($xml_object);
        $array = json_decode($json_string, true);

        return $array;
    }

    // სალარო აპარატის დღის ჯამები და მთლიანი ჯამი მითითებულ პერიოდში (ქვემომხმარებელი)
    public function zreportdetails()
    {

        $wsdl = 'https://services.rs.ge/taxservice/taxpayerservice.asmx?WSDl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        $client = new SoapClient($wsdl, $options);

        $params = [
            'UserName' => 'developer:26001001493',
            'Password' => 'Alaverda18$',
            'StartDate' => date('Y-m-d', strtotime('08/01/2024')),
            'EndDate' => date('Y-m-d', strtotime('08/31/2024')),
        ];

        //        Get_Z_Report_Sum
        //        Get_Z_Report_Details
        $response = $client->__soapCall('Get_Z_Report_Details', [$params]);

        return $response;
    }

    public function cash()
    {

        $wsdl = 'https://services.rs.ge/taxservice/taxpayerservice.asmx?WSDl';

        $options = [
            'trace' => true,
            'exceptions' => true,
        ];

        $client = new SoapClient($wsdl, $options);

        $params = [
            'user' => 'developer:26001001493',
            'password' => 'Alaverda18$',
        ];

        //        Get_Z_Report_Sum
        //        Get_Z_Report_Details
        $response = $client->__soapCall('Get_QuickCash_Info', [$params]);

        return $response;
    }

    // ზედნადების გამოწერა
    public function saveWaybill2()
    {
        // Example goods data
        $goodsList = [
            [
                'ID' => 0,
                'W_NAME' => 'წამალ',
                'UNIT_ID' => 1,
                'QUANTITY' => 5,
                'PRICE' => 3,
                'STATUS' => 1,
                'AMOUNT' => 15,
                'BAR_CODE' => 'hhhhh',
                'A_ID' => 0,
                'VAT_TYPE' => 0,
            ],
            [
                'ID' => 0,
                'W_NAME' => 'Another Item',
                'UNIT_ID' => 2,
                'QUANTITY' => 10,
                'PRICE' => 5,
                'STATUS' => 1,
                'AMOUNT' => 50,
                'BAR_CODE' => 'abcde',
                'A_ID' => 0,
                'VAT_TYPE' => 0,
            ],
            // Add more goods as needed
        ];

        // Create a new Guzzle client
        $client = new Client;

        // Prepare the SOAP XML request
        $soapXml = $this->generateSoapXml($goodsList);

        // Send the SOAP request
        $response = $client->post('http://services.rs.ge/WayBillService/WayBillService.asmx', [
            'headers' => [
                'Content-Type' => 'application/soap+xml; charset=utf-8; action="http://tempuri.org/save_waybill"',
            ],
            'body' => $soapXml,
        ]);

        //        dd($response)  ;

        //        $responseBody = $response->getBody()->getContents();
        //
        // //        return $responseBody;
        //
        //        $xml  = simplexml_load_string($responseBody);
        //        $json = json_encode($xml);
        //
        //        return response()->json($json);
        // //        return $responseBody;

        $responseBody = $response->getBody()->getContents();

        // 1. Load the XML
        $xml = simplexml_load_string($responseBody);

        // 2. Register the SOAP and RS.ge (tempuri) namespaces
        $xml->registerXPathNamespace('soap', 'http://www.w3.org/2003/05/soap-envelope');
        $xml->registerXPathNamespace('ns', 'http://tempuri.org/');

        // 3. Use XPath to find the specific result tag
        // The tag name for this method is usually <save_waybillResult>
        $result = $xml->xpath('//ns:save_waybillResponse/ns:save_waybillResult');

        if (! empty($result)) {
            // SimpleXML objects need to be cast to string/int to be clean

            // If the result itself is an ID or a simple status code:
            return response()->json(['status' => 'success', 'waybill_id' => $result]);
        }

        return response()->json(['status' => 'error', 'message' => 'Could not parse response'], 500);

    }

    private function generateSoapXml($goodsList)
    {
        $goodsXml = '';

        $startdate = date('Y-m-d', strtotime('08/31/2024'));
        $enddate = date('Y-m-d', strtotime('08/31/2024'));

        // Loop through goods and create XML for each one
        foreach ($goodsList as $goods) {
            $goodsXml .= <<<XML
                <GOODS>
                    <ID>{$goods['ID']}</ID>
                    <W_NAME>{$goods['W_NAME']}</W_NAME>
                    <UNIT_ID>{$goods['UNIT_ID']}</UNIT_ID>
                    <QUANTITY>{$goods['QUANTITY']}</QUANTITY>
                    <PRICE>{$goods['PRICE']}</PRICE>
                    <STATUS>{$goods['STATUS']}</STATUS>
                    <AMOUNT>{$goods['AMOUNT']}</AMOUNT>
                    <BAR_CODE>{$goods['BAR_CODE']}</BAR_CODE>
                    <A_ID>{$goods['A_ID']}</A_ID>
                    <VAT_TYPE>{$goods['VAT_TYPE']}</VAT_TYPE>
                </GOODS>
                XML;
        }

        //  ზედნადების ტიპები : 1 = შიდა გადაზიდვა; 2 = ტრანსპორტირებით; 3 = ტრანსპორტირების გარეშე; 4 = დისტრიბუცია; 5 = უკან დაბრუნება;
        $waybill_type = 3;

        //        "ServiceUser": {
        //        "ID": "568428",
        //        "USER_NAME": "DEVELOPER:01024064358",
        //        "UN_ID": "1290819",
        //        "NAME": []

        //        <S_USER_ID>568428</S_USER_ID> ==
        //        <SELER_UN_ID>1290819</SELER_UN_ID>  ==

        // Create the SOAP XML with hardcoded values
        return <<<XML
            <?xml version="1.0" encoding="utf-8"?>
            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
              <soap12:Body>
                <save_waybill xmlns="http://tempuri.org/">
                <su>TBILISI123456:206322102</su>
                <sp>Rs12345678*</sp>
                  <waybill>
                    <WAYBILL>
                      <GOODS_LIST>
                       {$goodsXml}
                      </GOODS_LIST>
                      <ID>0</ID>
                      <TYPE>{$waybill_type}</TYPE>
                      <BUYER_TIN>12345678910</BUYER_TIN>
                      <START_ADDRESS>თბილისი, საბურთალოს ქუჩა</START_ADDRESS>
                      <SELER_UN_ID>731937</SELER_UN_ID>
                      <STATUS>1</STATUS>
                      <FULL_AMOUNT>15</FULL_AMOUNT>
                      <WAYBILL_NUMBER>0652348978</WAYBILL_NUMBER>
                      <S_USER_ID>142004</S_USER_ID>
                      <COMMENT>sfsdfsf</COMMENT>
                      <CATEGORY>0</CATEGORY>
                      <IS_MED>0</IS_MED>
                    </WAYBILL>
                  </waybill>
                </save_waybill>
              </soap12:Body>
            </soap12:Envelope>
            XML;
    }

    public function issueWaybill(Request $request)
    {
        $order = Order::find($request->order_id);
        $waybill_type = 3;

        if ($order) {
            $goodsXml = '';
            $buyer_pid = $order->owner->pid;
            $comment = $request->comment;
            $rs_submuser = config('credentials.RS_SUBUSER');
            $rs_submuser_password = config('credentials.RS_SUBUSER_PASS');
            $rs_subuser_id = config('credentials.RS_S_USER_ID');
            $rs_seller_id = config('credentials.RS_SELLER_UN_ID');

            $grand_total = 0;
            foreach ($order->products_details as $goods) {
                $grand_total += $goods['quantity'] * $goods['price'];
                $totalAmount = $goods['quantity'] * $goods['price'];
                $goodsXml .= <<<XML
                <GOODS>
                    <ID>0</ID>
                    <W_NAME>{$goods['name']}</W_NAME>
                    <UNIT_ID>1</UNIT_ID>
                    <QUANTITY>{$goods['quantity']}</QUANTITY>
                    <PRICE>{$goods['price']}</PRICE>
                    <STATUS>1</STATUS>
                    <AMOUNT>$totalAmount</AMOUNT>
                    <BAR_CODE>{$goods['sku']}</BAR_CODE>
                    <A_ID>0</A_ID>
                    <VAT_TYPE>0</VAT_TYPE>
                </GOODS>
                XML;
            }

            $data = <<<XML
            <?xml version="1.0" encoding="utf-8"?>
            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
              <soap12:Body>
                <save_waybill xmlns="http://tempuri.org/">
                <su>$rs_submuser</su>
                <sp>$rs_submuser_password</sp>
                  <waybill>
                    <WAYBILL>
                      <GOODS_LIST>
                       $goodsXml
                      </GOODS_LIST>
                      <ID>0</ID>
                      <TYPE>$waybill_type</TYPE>
                      <BUYER_TIN>$buyer_pid</BUYER_TIN>
                      <START_ADDRESS>$order->address</START_ADDRESS>
                      <SELER_UN_ID>$rs_seller_id</SELER_UN_ID>
                      <STATUS>1</STATUS>
                      <FULL_AMOUNT>$grand_total</FULL_AMOUNT>
                      <WAYBILL_NUMBER>0</WAYBILL_NUMBER>
                      <S_USER_ID>$rs_subuser_id</S_USER_ID>
                      <COMMENT>$comment</COMMENT>
                      <CATEGORY>0</CATEGORY>
                      <IS_MED>0</IS_MED>
                    </WAYBILL>
                  </waybill>
                </save_waybill>
              </soap12:Body>
            </soap12:Envelope>
            XML;

            $client = new Client;

            $response = $client->post('http://services.rs.ge/WayBillService/WayBillService.asmx', [
                'headers' => [
                    'Content-Type' => 'application/soap+xml; charset=utf-8; action="http://tempuri.org/save_waybill"',
                ],
                'body' => $data,
            ]);

            //        dd($response)  ;

            //        $responseBody = $response->getBody()->getContents();
            //
            // //        return $responseBody;
            //
            //        $xml  = simplexml_load_string($responseBody);
            //        $json = json_encode($xml);
            //
            //        return response()->json($json);
            // //        return $responseBody;

            $responseBody = $response->getBody()->getContents();

            // 1. Load the XML
            $xml = simplexml_load_string($responseBody);

            // 2. Register the SOAP and RS.ge (tempuri) namespaces
            $xml->registerXPathNamespace('soap', 'http://www.w3.org/2003/05/soap-envelope');
            $xml->registerXPathNamespace('ns', 'http://tempuri.org/');

            // 3. Use XPath to find the specific result tag
            // The tag name for this method is usually <save_waybillResult>
            $result = $xml->xpath('//ns:save_waybillResponse/ns:save_waybillResult');

            if (! empty($result)) {
                // SimpleXML objects need to be cast to string/int to be clean
                //               $id=$result

                // If the result itself is an ID or a simple status code:
                return $result;
            }

            return response()->json(['status' => 'error', 'message' => 'Could not parse response'], 500);
        }

        return back()->with('alert_error', 'Order not found');
    }

    public function withTransport(Request $request)
    {
        $order = Order::find($request->order_id);
        // ტრანსპორტირებით
        $waybill_type = 2;

        if ($order) {
            $goodsXml = '';
            $buyer_pid = $order->owner->pid;
            if ($buyer_pid == null) {
                return back()->with('alert_error', 'Customer does not have PID');
            }
            $comment = $request->comment;
            $car_number = 'HH989PP';
            $driver_pid = '26701040495';

            $rs_submuser = config('credentials.RS_SUBUSER');
            $rs_submuser_password = config('credentials.RS_SUBUSER_PASS');
            $rs_subuser_id = config('credentials.RS_S_USER_ID');
            $rs_seller_id = config('credentials.RS_SELLER_UN_ID');

            $grand_total = 0;
            foreach ($order->products_details as $goods) {
                $grand_total += $goods['quantity'] * $goods['price'];
                $totalAmount = $goods['quantity'] * $goods['price'];
                $goodsXml .= <<<XML
                <GOODS>
                    <ID>0</ID>
                    <W_NAME>{$goods['name']}</W_NAME>
                    <UNIT_ID>1</UNIT_ID>
                    <QUANTITY>{$goods['quantity']}</QUANTITY>
                    <PRICE>{$goods['price']}</PRICE>
                    <STATUS>1</STATUS>
                    <AMOUNT>$totalAmount</AMOUNT>
                    <BAR_CODE>{$goods['sku']}</BAR_CODE>
                    <A_ID>0</A_ID>
                    <VAT_TYPE>0</VAT_TYPE>
                </GOODS>
                XML;
            }
            $begin_date = now()->addMinutes(1)->format('Y-m-d\TH:i:s');
            $data = <<<XML
            <?xml version="1.0" encoding="utf-8"?>
            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
              <soap12:Body>
                <save_waybill xmlns="http://tempuri.org/">
                <su>$rs_submuser</su>
                <sp>$rs_submuser_password</sp>
                  <waybill>
                    <WAYBILL>
                      <GOODS_LIST>
                       $goodsXml
                      </GOODS_LIST>
                      <ID>0</ID>
                      <TYPE>2</TYPE>
                      <TRANS_ID>1</TRANS_ID>
                      <BEGIN_DATE>$begin_date</BEGIN_DATE>
                      <BUYER_TIN>$buyer_pid</BUYER_TIN>
                      <CHEK_BUYER_TIN>1</CHEK_BUYER_TIN>
                      <START_ADDRESS>თბილისი</START_ADDRESS>
                      <END_ADDRESS>$order->address</END_ADDRESS>
                      <DRIVER_TIN>$driver_pid</DRIVER_TIN>
                      <CHEK_DRIVER_TIN>1</CHEK_DRIVER_TIN>
                      <DRIVER_NAME>ირაკლი</DRIVER_NAME>
                      <TRANSPORT_COAST>0</TRANSPORT_COAST>
                      <STATUS>1</STATUS>
                      <SELER_UN_ID>$rs_seller_id</SELER_UN_ID>
                      <FULL_AMOUNT>$grand_total</FULL_AMOUNT>
                      <CAR_NUMBER>$car_number</CAR_NUMBER>
                      <WAYBILL_NUMBER>1</WAYBILL_NUMBER>
                      <S_USER_ID>$rs_subuser_id</S_USER_ID>
                      <TRAN_COST_PAYER>2</TRAN_COST_PAYER>
                      <COMMENT>$comment</COMMENT>
                      <CATEGORY>0</CATEGORY>
                      <IS_MED>0</IS_MED>
                    </WAYBILL>
                  </waybill>
                </save_waybill>
              </soap12:Body>
            </soap12:Envelope>
            XML;

            $client = new Client;

            $response = $client->post('http://services.rs.ge/WayBillService/WayBillService.asmx', [
                'headers' => [
                    'Content-Type' => 'application/soap+xml; charset=utf-8; action="http://tempuri.org/save_waybill"',
                ],
                'body' => $data,
            ]);

            $responseBody = $response->getBody()->getContents();

            // 1. Load the XML
            $xml = simplexml_load_string($responseBody);

            // 2. Register the SOAP and RS.ge (tempuri) namespaces
            $xml->registerXPathNamespace('soap', 'http://www.w3.org/2003/05/soap-envelope');
            $xml->registerXPathNamespace('ns', 'http://tempuri.org/');

            // 3. Use XPath to find the specific result tag
            // The tag name for this method is usually <save_waybillResult>
            $result = $xml->xpath('//ns:save_waybillResponse/ns:save_waybillResult');

            if (! empty($result)) {
                $resultArray = json_decode(json_encode($result[0]->RESULT), true);
                if ($result[0]->RESULT->STATUS == 0) {

                    Log::channel('waybill')->info('waybill result', ['result' => $resultArray]);

                    $waybillData = $result[0]->RESULT;

                    $status = (string) $waybillData->STATUS;
                    $waybillId = (string) $waybillData->ID;
                    $waybillNumber = (string) $waybillData->WAYBILL_NUMBER;

                    $waybill = new WayBill;
                    $waybill->status = $status;
                    $waybill->order_id = $order->id;
                    $waybill->waybill_number = $waybillNumber;
                    $waybill->waybill_id = $waybillId;
                    $waybill->type = 'transportation';
                    $waybill->save();

                    return back()->with('alert_success', 'Transportation Waybill issued');
                }
                Log::channel('waybill')->error('waybill result', ['result' => $resultArray]);

                return back()->with('alert_error', 'Error');

            }

            return response()->json(['status' => 'error', 'message' => 'Could not parse response'], 500);
        }

        return back()->with('alert_error', 'Order not found');
    }

    public function finish(Request $request)
    {

        $waybill = Waybill::where('order_id', $request->order_id)->first();
        $order = Order::where('id', $waybill->order_id)->first();

        if ($waybill) {

            $wsdl = 'https://services.rs.ge/WayBillService/WayBillService.asmx?wsdl';

            $options = [
                'trace' => true,
                'exceptions' => true,
            ];

            try {
                $client = new SoapClient($wsdl, $options);

                $params = [
                    'su' => config('credentials.RS_SUBUSER'),
                    'sp' => config('credentials.RS_SUBUSER_PASS'),
                    'waybill_id' => $waybill->waybill_id,
                ];

                $response = $client->__soapCall('close_waybill', [$params]);
                $resultCode = $response->close_waybillResult;

                if ($resultCode == 1) {
                    $waybill->is_finished = true;
                    $waybill->save();
                    $order->is_delivered = true;
                    $order->save();

                    return back()->with('alert_success', ' waybill finished');
                } else {
                    Log::channel('waybill')->error('finish error', ['result' => $resultCode]);

                    return back()->with('alert_error', 'Error '.$resultCode);
                }

            } catch (\Exception $e) {
                Log::channel('waybill')->error('finish apicall error', ['result' => $e]);

                return back()->with('alert_error', 'Finish API call error');
            }

        }

        return back()->with('alert_error', 'Order not found');
    }
}
