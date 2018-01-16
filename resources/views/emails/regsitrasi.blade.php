@component('mail::message')

hi there,<br>
Thanks for signing up to keep in touch with www.nulife.co.id<br>
From now on, you'll get Achieve mutual prosperity with www.nulife.co.id<br>
Here your personal identity :

<table cellpadding="0" cellspacing="0" style="color:#000;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:13px;line-height:22px;table-layout:auto" width="100%" border="0">
        <tbody><tr>
                <td style="border-bottom:1px dotted #ecedee;text-align:right;padding:15px 20px 0 0;background-color:#fafafa">Name</td>
                <td style="border-bottom:1px dotted #ecedee;text-align:left;padding:15px 0 0 20px;background-color:#fafafa"><strong>{{$data['dataNewMember']['name']}}</strong></td>
        </tr>
        <tr>
                <td style="border-bottom:1px dotted #ecedee;text-align:right;padding:15px 20px 0 0">Email</td>
                <td style="border-bottom:1px dotted #ecedee;text-align:left;padding:15px 0 0 20px"><strong><a href="mailto:{{$data['dataNewMember']['name']}}" target="_blank">{{$data['dataNewMember']['email']}}</a></strong></td>
        </tr>
        <tr>
                <td style="border-bottom:1px dotted #ecedee;text-align:right;padding:15px 20px 0 0;background-color:#fafafa">User ID</td>
                <td style="border-bottom:1px dotted #ecedee;text-align:left;padding:15px 0 0 20px;background-color:#fafafa"><strong>{{$data['dataNewMember']['userid']}}</strong></td>
        </tr>
        <tr>
                <td style="border-bottom:1px dotted #ecedee;text-align:right;padding:15px 20px 0 0;background-color:#fafafa">Registration Date</td>
                <td style="border-bottom:1px dotted #ecedee;text-align:left;padding:15px 0 0 20px;background-color:#fafafa"><strong>{{$data['tglDaftar']}}</strong></td>
        </tr>
</tbody>
</table>

@component('mail::button', ['url' => route('home').'/activation/'.$data['url']])
Email Verification
@endcomponent

This link will not active in 2 x 24 hours
@endcomponent
