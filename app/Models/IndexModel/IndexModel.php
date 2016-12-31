<?php

namespace App\Models\IndexModel;

use Illuminate\Database\Eloquent\Model;
use DB;
use log;
use DateTime;

session_write_close();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
class IndexModel extends Model
{
    public static function TodayOrder(array $options)
    {
        try {
            if (isset($options['today'])) {
                $startDate = date('Y-m-d') . " 00:00:00";
                $endDate = date('Y-m-d') . " 23:59:59";
            }
            if (isset($options['yesterday'])) {
                $Date = new DateTime();
                $Date->modify('-1 day');
                $startDate = $Date->format('Y-m-d 00:00:00');
                $endDate = $Date->format('Y-m-d 23:59:59');
            }
//            $company_id = $_SESSION['c_id'];//
            $company_id = 170;
            $data = DB::table("ee_suborders as so");
            $data=$data->whereBetween("order_date",[$startDate,$endDate]);
            $data = $data->where('company_id', '=', $company_id)->count();

            return $data;
        } catch (\Exception $e) {
            echo "Error in  TodayOrders" . $e->getMessage();
            Log::Error("Error in TodayOrders Model" . $e->getMessage());
            return 808;
        }
    }

    public static function TodayRevenue(array $options)
    {
        try {
            if (isset($options['today'])) {
                $startDate = date('Y-m-d') . " 00:00:00";
                $endDate = date('Y-m-d') . " 23:59:59";
            }
            if (isset($options['yesterday'])) {
                $Date = new DateTime();
                $Date->modify('-1 day');
                $startDate = $Date->format('Y-m-d 00:00:00');
                $endDate = $Date->format('Y-m-d 23:59:59');
            }
//            $vendor_c_id = $_SESSION['c_id'];
            $vendor_c_id = 170;
            $data = DB::table('ee_suborders as so');
            $data = $data->select('ci.amount as amount');
            $data = $data->join('ee_company_invoice_details as cid', 'so.id', '=', 'cid.suborder_id');
            $data = $data->join('ee_company_invoices as ci', 'cid.company_invoice_id', '=', 'ci.id');
            $data = $data->whereBetween('ci.invoice_date', [$startDate, $endDate]);
            $data = $data->where('so.company_id', '=', $vendor_c_id)->sum('ci.amount');
            return $data;
        } catch (\Exception $e) {
            echo "Error in Revenue" . $e->getMessage();
            Log::Error("Error in Revenue Model" . $e->getMessage());
            return 808;
        }
    }


    public static function PendingReturnsOrders(array $options)
    {
        try {
//            $company_id = $_SESSION['c_id'];
            $company_id = 170;
            if (isset($options['orders'])) {
                $data = EeSuborder::where('status_id', '=', 1);
                $data = $data->where('company_id', '=', $company_id)->count();
            }
            if (isset($options['returns'])) {


                $data = DB::table('ee_return_history as rh');
                $data=$data->selectRaw('ci.amount');
                $data = $data->join('ee_suborders as so', 'so.id', '=', 'rh.marketplace_order_id');
                $data=$data->leftJoin('ee_return_reason as rr','rr.id','=','rh.return_reason_id');
                $data=$data->join('ee_orders as o','so.order_id','=','o.id');
                $data=$data->join('ee_company_invoice_details as cid','cid.suborder_id','=','so.id');
                $data=$data->join('ee_company_invoices as ci','ci.id','=','cid.company_invoice_id');
                $data=$data->leftJoin('ee_return_types as rt','rt.id','=','rh.return_type_id');
                $data = $data->where('so.company_id', '=', $company_id);
                $data = $data->where('rh.return_status', '=', 1);
                $data = $data->where('so.status_id', '!=',9);
                $data = $data->where('ci.invoice_date', '>=',"2016-01-01");
                $data=$data->groupBy('cid.company_invoice_id');
                $data = $data->get();
                $count=0;
                foreach ($data as $k=>$v)
                {
                    $count++;
                }
                return $count;
            }
            return $data;
        } catch (\Exception $e) {
            echo "Error in Returns" . $e->getMessage();
            Log::Error("Error in Returns Model" . $e->getMessage());
            return 808;
        }
    }


    public static function CriticalOrders(array $options)
    {
        try {
//            $company_id = $_SESSION['c_id'];
            $company_id = 170;
            if (isset($options['critical'])) {
                $data = DB::table('ee_suborders as so');
                $data = $data->selectRaw('TIME_TO_SEC(TIMEDIFF(so.dispatch_by_date,now())) as diff');
                $data = $data->where('so.company_id', '=', $company_id);
                $data = $data->where(DB::raw('TIME_TO_SEC(TIMEDIFF(so.dispatch_by_date,now()))'), '<=', 86400);
                $data = $data->where(DB::raw('TIME_TO_SEC(TIMEDIFF(so.dispatch_by_date,now()))'), '>', 0);
                $data=$data->where("status_id","<",7);
            }
            if (isset($options['sla'])) {
                $data = DB::table('ee_suborders as so');
                $data = $data->selectRaw('TIME_TO_SEC(TIMEDIFF(so.dispatch_by_date,now())) as diff');
                $data = $data->where('so.company_id', '=', $company_id);
                $data = $data->where(DB::raw('TIME_TO_SEC(TIMEDIFF(so.dispatch_by_date,now()))'), '<', 0);
                $data=$data->where("status_id","<",7);
            }

            $data = $data->count();
            return $data;
        } catch (\Exception $e) {
            echo "Error in CriticalOrders" . $e->getMessage();
            Log::Error("Error in CriticalOrders Model" . $e->getMessage());
            return 808;
        }
    }


    public static function MarketPlaceCredentials(array $options)
    {
        try {
//            $company_id = $_SESSION['c_id'];
            $company_id = 170;
//            $uid = $_SESSION['u_id'];
            $uid = 170;
            if (isset($options['Mp'])) {
                $data = DB::table('ee_company_credentials as cc');
                $data = $data->selectRaw('m.name as marketplace,ps.name as status,ps.id as status_id');
                $data = $data->join('ee_marketplaces as m', 'cc.m_id', '=', 'm.id');
                $data = $data->join('ee_portal_status as ps', 'cc.portal_status', '=', 'ps.id');
                $data = $data->where('cc.c_id', '=', $company_id);
                // $data = $data->where('ps.id', '!=', 1);

                $data = $data->get();
            }
            if (isset($options['profile'])) {

                $data = DB::table('ee_company as c');
                $data = $data->selectRaw('c.c_id as Seller_id,c.companyname as Company_name,u.primary_contact as mb,c.pan as pan,c.tin as tin,
                c.cst as cst,c.Lst as lst,c.vat as vat,c.customer_support_email,c.customer_support_contact');
                $data = $data->leftJoin('ee_users as u', 'u.c_id', '=', 'c.c_id');
                $data = $data->where('c.c_id', '=', $company_id);
                $data = $data->where('id', '=', $uid);
                $data = $data->get();

                $address = DB::table('ee_address as ad');
                $address = $address->selectRaw('*');
                $address = $address->where('ad.c_id', '=', $company_id);

                $address = $address->get();

                $channel = DB::select('select m.name
                                           from ee_company_credentials cc
                                           inner join ee_marketplaces m on m.id=cc.m_id
                                           where cc.c_id ='.$company_id.' ');

                $invoiceGroupSetting=DB::select('select cig.id, description,Group_CONCAT(m.name) \'name\',(invoice_offset_number)  \'series\' ,
                                                    group_concat(m.id) \'m_ids\', invoice_prefix,
                                                    cig.start_year \'start_year\', cig.end_year \'end_year\'
                                                    from ee_company_invoice_group cig
                                                      left join ee_company_invoice_group_details cigd on cigd.company_invoice_group_id = cig.id
                                                      left join ee_marketplaces m on m.c_id=cigd.company_id
                                                    where cig.company_id='.$company_id.' group by cig.id');

                $arr = array();
                $arr = [$data, $address,$channel,$invoiceGroupSetting];
                return $arr;
            }

            return $data;
        } catch (\Exception $e) {
            echo "Error in MarketPlaceCredentials" . $e->getMessage();
            Log::Error("Error in MarketPlaceCredentials Model" . $e->getMessage());
            return 808;
        }

    }

    public static function Announcement()
    {
        try {
            $data = DB::table('ee_suborders as so');
            $data = $data->selectRaw('bl.post_title,bl.guid,bl.post_date as date');
            $data = $data->join('ezblgs.eeblg_posts as bl', 'so.id', '=', 'bl.ID');
            $data = $data->where('bl.post_status', '=', 'publish');
            $data = $data->where('bl.comment_status', '=', 'open');
            $data = $data->orderBy('date', 'desc');
            $data = $data->limit(5);
            $data = $data->get();
            return $data;
        } catch (\Exception $e) {
            echo "Error in Announcement" . $e->getMessage();
            Log::Error("Error in Announcement Model" . $e->getMessage());
            return 808;
        }
    }


    public static function GetApiData(){
//        $c_id=$_SESSION['c_id'];
        $c_id=170;
        $startDate=date('Y-m-d')." 00:00:00";
        $endDate=date('Y-m-d')." 23:59:59";

        $data=DB::select('select aq.process_date,count(aq.id) as quantity ,m.id,m.name, aq.id \'api_queue_id\',    aq.queue_date,aq.status_id\'queue_status\',aqs.name\'status_name\'  from ee_api_queue aq
  INNER JOIN ee_company_product_listings cpl ON cpl.id = aq.listing_id
  LEFT JOIN ee_listing_status ls on cpl.listing_status_id = ls.id
  INNER JOIN ee_marketplaces as m on cpl.marketplaceID = m.id
  INNER JOIN ee_company_product cp ON cp.id = cpl.company_product_id
  INNER JOIN api_actions aa ON aa.id = aq.api_action_id
  INNER JOIN ee_company c ON c.c_id = cp.c_id
  INNER JOIN ee_api_queue_status aqs on aq.status_id = aqs.id
where aq.queue_date BETWEEN "'.$startDate.'" and "'.$endDate.'"
      AND aq.api_action_id in (4)
      AND aq.status_id in (1,2,3,4)
      AND cp.active=1
      AND cp.c_id ='.$c_id.'
GROUP BY  m.id,aqs.id
ORDER BY aq.queue_date DESC');
        return $data;
    }

}

