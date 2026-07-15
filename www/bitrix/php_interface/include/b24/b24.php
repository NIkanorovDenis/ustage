<?
AddEventHandler("main", "OnAfterCrmDealAdd", "NewDeal");
function NewDeal($arFields)
{
    $res = '';
    foreach ($arFields as $key => $val) {
        $res .= " " . $key . " - " . $val . " -- ";
    }

   
    return 1;
}

function mainProcess()
{
    CModule::IncludeModule('crm'); //crm
    CModule::IncludeModule("tasks"); //задачи
    CModule::IncludeModule('bizproc');

    global $DB;
    //ПОлучаем список новых сделок

    $data = $DB->Query("SELECT ID, TIMESTAMPDIFF(MINUTE, CREATED_DATE, '".date("Y-m-d H:i:s")."') as T FROM b_tasks 
          WHERE STATUS=2 AND TITLE='Взять проект в работу' AND RESPONSIBLE_ID = 269");
    while ($info = $data->Fetch())
    {
        if($info["T"] > 30)
        {
            $DB->Query("UPDATE b_tasks SET RESPONSIBLE_ID=4 WHERE ID=".$info["ID"]);
        }
    }

    return "mainProcess();";
}

AddEventHandler("tasks", "OnTaskUpdate", "processTask");
function processTask($id, $data)
{
    CModule::IncludeModule('crm'); //crm
    CModule::IncludeModule("tasks"); //задачи

    global $DB;
    $stats = Array();
    $stats[0] = "NEW";
    $stats[1] = "6";
    $stats[2] = "PREPAYMENT_INVOICE";
    $stats[3] = "EXECUTING";
    $stats[4] = "1";
    $stats[5] = "FINAL_INVOICE";
    $stats[6] = "2";
    $stats[7] = "3";
    $stats[8] = "4";
    $stats[9] = "5";
    $stats[10] = "WON";

    if ($data["STATUS"] == 5) {
        //ОБрабатываем закрытие

        $data = $DB->Query("SELECT * FROM b_utm_tasks_task WHERE VALUE_ID=" . $id);
        if ($data->SelectedRowsCount() > 0) {
            $info = $data->Fetch();
            $val = $info["VALUE"];
            $dealID = substr($val, 2);


            $dealdata = $DB->Query("SELECT * FROM b_crm_deal WHERE ID=" . $dealID);
            $dealInfo = $dealdata->Fetch();
            $stageID = $dealInfo["STAGE_ID"];
            $str = $dealID;
            $k = array_search($stageID, $stats);

            if (($k < 10)) {

                $k++;
                $newstage = $stats[$k];
                $deal = new CCrmDeal;


                $tdata = $DB->Query("SELECT * FROM b_uts_crm_deal WHERE VALUE_ID=" . $dealID);
                $tinfo = $tdata->Fetch();
                if (($tinfo["UF_CRM_1613800288"] == 117) && ($newstage == "PREPAYMENT_INVOICE"))
                    $newstage = "1";

                $arUpdateData = array(
                    'STAGE_ID' => $newstage
                );

                //mail('shaposhnikov.i@redmond.company','taskin', $id ."  ".$dealID."  ".$newstage);
				// $deal->Update($dealID, $arUpdateData, true, true);
				// $str .= "  " . $deal->LAST_ERROR;
                //mail('shaposhnikov.i@redmond.company','taskup', $str);


                //Создаем следующую задачу
                $title = '';
                if ($newstage != "WON") {
                    if ($newstage == 6)
                        $title = "Квалифицировать клиента";
                    if ($newstage == "PREPAYMENT_INVOICE")
                        $title = "Назначить встречу";
                    if ($newstage == "EXECUTING")
                        $title = "Встреча с клиентом";
                    if ($newstage == 1)
                        $title = "Отправить на расчёт";
                    if ($newstage == "FINAL_INVOICE")
                        $title = "Получить расчет";
                    if ($newstage == 2)
                        $title = "Отправить КП";
                    if ($newstage == 3)
                        $title = "Проверить получение КП";

                    if ($newstage == 4)
                        $title = "Выставить счет";
                    if ($newstage == 5)
                        $title = "Проверить оплату счета";

                    $newTask = array(
                        "TITLE" => $title,
                        "DESCRIPTION" => $title,
                        "RESPONSIBLE_ID" => Array(269),//ответственный
                        //"TASK_CONTROL" => "Y",
                        "ADD_IN_REPORT" => "Y",

                        "UF_CRM_TASK" => Array("D_" . $dealID) //ID сделки
                    );


                    $taskItem = \CTaskItem::add($newTask, 269);
                }

            }
        }
    }

    // mail('shaposhnikov.i@redmond.company','task', $str);
}

//AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");
function OnAfterIBlockElementAddHandler(&$arFields)
{
    if (!$arFields["RESULT"]) return false;
    If ($arFields['IBLOCK_ID'] == 7) { //инфоблок новостей
        $res = CIBlockElement::GetByID($arFields['ID']);

        CModule::IncludeModule('crm'); //crm
        CModule::IncludeModule("tasks"); //задачи
        CModule::IncludeModule('bizproc'); //бизнес-процессы


        if ($ob = $res->GetNextElement()) {
            $arProps = $ob->GetProperties();

            $arNewCompany = array(
                "TITLE" => $arProps["FIO"]["VALUE"],
                "OPENED" => "Y",
                "COMPANY_TYPE" => "CUSTOMER",

            );
            $arNewCompany['FM']['PHONE'] = array(
                'n0' => array(
                    'VALUE_TYPE' => 'WORK',
                    'VALUE' => $arProps["PHONE"]["VALUE"],
                )
            );
            $arNewCompany['FM']['EMAIL'] = array(
                'n0' => array(
                    'VALUE_TYPE' => 'WORK',
                    'VALUE' => $arProps["EMAIL"]["VALUE"],
                )
            );
            $company = new CCrmCompany(false);
            $companyID = $company->Add($arNewCompany);

            $arFields = array(
                "TITLE" => "Сделка из формы",
                "TYPE_ID" => "SALE",
                "STAGE_ID" => "NEW",
                "COMPANY_ID" => $companyID,
                "OPENED" => "Y",
                "SOURCE_DESCRIPTION" => $arProps["ANSWER"]["VALUE"]

            );
//$options = array('CURRENT_USER'=>1); //из под админа
            $deal = new CCrmDeal(false);
            $arErrorsTmp = Array();
            $dealId = $deal->Add($arFields, true);
            $newTask = array(
                "TITLE" => "Взять сделку в работу",
                "DESCRIPTION" => "Взять сделку в работу",
                "RESPONSIBLE_ID" => 269,//ответственный
                //"TASK_CONTROL" => "Y",
                "ADD_IN_REPORT" => "Y",

                "UF_CRM_TASK" => Array("D_" . $dealId) //ID сделки
            );

            $taskItem = \CTaskItem::add($newTask, 269);

            /*
            if ($dealId > 0) {
                CModule::IncludeModule('bizproc'); //запускаем робота для текущей стадии сделки
                $arErrors = Array();
                CBPDocument::StartWorkflow(
                    19,  //ID робота, смотреть через таблицы
                    array("crm", "CCrmDocumentDeal", "DEAL_" . $dealId),
                    array(),
                    $arErrorsTmp
                );
            }
            */

        }

    }
}

?>