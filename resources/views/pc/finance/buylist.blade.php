<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>投资记录</title>

    <link href="{{asset("pc/finance/css/css/c_main.min.css")}}" rel="stylesheet" type="text/css"/>

    <style>
        /* 分页 */
        .gb_pages{ text-align:center;width: 1100px;}
        #pages { padding:14px 0 10px; font-family:宋体; text-align:center }
        #pages a { display:inline-block; height:22px; line-height:22px; background:#fff; border:1px solid #e3e3e3; text-align:center; color:#333; padding:0 10px}
        #pages a.a1 { background:url(../images/admin_img/pages.png) no-repeat 0 5px; width:56px; padding:0 }
        #pages a:hover { background:#f1f1f1; color:#000; text-decoration:none }
        #pages span { display:inline-block; height:22px; line-height:22px; background:#0078E8; border:1px solid #0078E8; color:#fff; text-align:center;padding:0 10px}
        .page .noPage { display:inline-block; width:56px; height:22px; line-height:22px; background:url(../img/icu/titleBg.png) repeat-x 0 -55px ; border:1px solid #e3e3e3; text-align:center; color:#a4a4a4; }
        .c_table_two2 {
            width: 100%;
            text-align: center;
            color: #fff
        }
        .c_table_two2 th {
            /* background: #C02F4D;*/
            background:#FFA306;
            height: 40px;
            font-size: 16px;
            color: #fff;
            text-align: center
        }
        .c_table_two2 td {
            height: 40px;
            color: #666;
            font-size: 16px;
            border-color: #eee
        }
        .c_table_two2 .c_table_addcolor td {
            background: #e6e9ed
        }
        .c_table_two {
            width: 100%;
            text-align: center;
            color: #fff
        }
        .c_table_two th {
            /* background: #C02F4D;*/
            background:#FFA306;
            height: 40px;
            font-size: 16px;
            color: #fff;
            text-align: center
        }
        .c_table_two td {
            height: 40px;
            color: #666;
            font-size: 16px;
            border-color: #eee
        }
        .c_table_two .c_table_addcolor td {
            background: #e6e9ed
        }
        .c_product_list h4 {
            font-size: 14px;
            color: #000;
            margin-top: 30px;
            padding: 0 20px
        }
        .c_product_list .c_p_three {
            font-size: 14px;
            color: #666;
            line-height: 30px;
            padding: 0 20px
        }
        .c_new_product {
            display: none
        }
    </style>



</head><body><table class="c_table_two" id="tenderListTable" border="1">
    <tbody>
    <tr>
        <th>序号</th>
        <th>理财人</th>
        <th>有效金额（元）</th>
        <th>来源</th>
        <th>投标时间</th>
    </tr>

    @foreach(\App\Productbuy::GetBuyList($productview->id) as $buyk=>$buy)
        <tr>
            <td class="c_table_addcolor">{{$buyk+1}}</td>
            <td class="c_table_addcolor">
                <a href="#" title="{{$buy['title']}}">{{$buy['mobile']}}</a></td>
            <td class="c_table_addcolor">{{$buy['amount']}}</td>
            <td class="c_table_addcolor">
                <img title="{{$buy['title']}}" src="{{$buy['RegFrom']}}"> </td>
            <td class="c_table_addcolor">{{$buy['DateTime']}}</td>
        </tr>
    @endforeach


    </tbody></table>
<div id="tenderListPage" class="pageStr" style="border:1px solid #999; line-height:40px;width: 100%;" align="center">
                                <span>
                                    <font color="#999999">仅显示最新10条记录，({{$productview->title}})用户可到个人中心查看您的投资记录</font>
                                </span>
</div>


</body></html>