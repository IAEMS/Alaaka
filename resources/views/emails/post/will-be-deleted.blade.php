@extends('emails.layouts.master')
@section('title', trans('mail.post_will_be_deleted_title', ['title' => $post->title, 'days' => $days]))

@section('content')
<table class="body-wrap" bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 20px;">
<tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
    <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
    <td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; display: block !important; max-width: 600px !important; Margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">
    <!-- content -->
    <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; display: block; max-width: 600px; margin: 0 auto; padding: 0;">
    <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0;">
        <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
            <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">@lang('mail.post_will_be_deleted_content_1', [
                        'title'     => mb_ucfirst($post->title),
                        'days'      => $days,
                        'appName'   => config('app.name')
                    ])
                    @lang('mail.post_will_be_deleted_content_2', [
                        'repostLink' => lurl('account/archived/' . $post->id . '/repost/')
                    ])
                    @lang('mail.post_will_be_deleted_content_3', [
                        'dateDel' => $post->created_at->addMonths(4)->formatLocalized('%d %B %Y')
                    ])
                    @lang('mail.post_will_be_deleted_content_4')
                    @lang('mail.post_will_be_deleted_content_5', [
                        'appName' => config('app.name')
                    ])
                    @lang('mail.post_will_be_deleted_content_6')</p>
            </td>
        </tr>
    </table>
    </div>
    <!-- /content -->
    </td>
    <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
</tr>
</table>
@endsection