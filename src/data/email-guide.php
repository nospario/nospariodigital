<?php
/**
 * Content for the email setup guide (/email-setup).
 *
 * Inline formatting (rendered by fmt() in lib/helpers.php):
 *   **bold**   → <strong>
 *   `code`     → <code> (server names, ports)
 *   [text](url) → link
 *
 * Step fields are [label, imapValue, popValue?]. When popValue is given, the
 * page shows both and the IMAP/POP switch picks one (no-JS: both are shown).
 */

declare(strict_types=1);

$FULL = 'your full email address';
$PW   = 'your email password';
$IMAP = '`imap.extendcp.co.uk`';
$POP  = '`pop3.extendcp.co.uk`';
$OUT  = '`mta.extendcp.co.uk`';

return [
    'webmail' => 'https://outitgoes.com/',

    // "Your settings at a glance". Rows: [label, value, copyable].
    'settings' => [
        'imap' => [
            'title' => 'Incoming mail (IMAP)', 'badge' => 'Recommended',
            'rows'  => [
                ['Account type', 'IMAP', false],
                ['Incoming server', 'imap.extendcp.co.uk', true],
                ['Port', '993', true],
                ['Security', 'SSL/TLS (or tick "Use SSL")', false],
                ['Username', $FULL, false],
                ['Password', $PW, false],
            ],
        ],
        'pop' => [
            'title' => 'Incoming mail (POP)', 'badge' => 'POP3',
            'rows'  => [
                ['Account type', 'POP (sometimes shown as POP3)', false],
                ['Incoming server', 'pop3.extendcp.co.uk', true],
                ['Port', '995', true],
                ['Security', 'SSL/TLS (or tick "Use SSL")', false],
                ['Username', $FULL, false],
                ['Password', $PW, false],
            ],
        ],
        'out' => [
            'title' => 'Outgoing mail (SMTP)', 'badge' => 'IMAP & POP',
            'rows'  => [
                ['Outgoing server', 'mta.extendcp.co.uk', true],
                ['Port', '587', true],
                ['Security', 'STARTTLS (if not offered, choose TLS or tick "Use SSL")', false],
                ['Requires sign-in', 'Yes, using a password', false],
                ['Username', $FULL, false],
                ['Password', $PW, false],
            ],
        ],
    ],

    // Device guides. Notes: [tone, title, text|paras[]]. Tones: important, tip, test, warn.
    // 'pop' notes only show when POP is selected.
    'devices' => [
        [
            'id' => 'iphone', 'label' => 'iPhone & iPad', 'sub' => 'Apple Mail app',
            'variants' => [[
                'id' => 'ios', 'heading' => 'iPhone and iPad (Apple Mail app)',
                'intro' => 'These steps are for iOS 18 and later. On older versions, steps 1–3 are **Settings > Mail > Accounts** instead.',
                'parts' => [
                    ['title' => 'Part 1: Add the account', 'steps' => [
                        ['t' => 'Open the **Settings** app (the grey cog icon).'],
                        ['t' => 'Scroll down and tap **Apps**, then tap **Mail**.'],
                        ['t' => 'Tap **Mail Accounts**, then **Add Account**.'],
                        ['t' => "Tap **Other** at the bottom of the list (don't choose Google, Outlook or the others)."],
                        ['t' => 'Tap **Add Mail Account**.'],
                        ['t' => 'Fill in:', 'f' => [['Name', 'your name as you want people to see it, for example Jane Smith'], ['Email', $FULL], ['Password', $PW], ['Description', 'anything that helps you recognise it, for example Work email']]],
                        ['t' => 'Tap **Next**. After a moment, a longer form appears.'],
                        ['t' => 'At the top, tap **IMAP** (recommended) or **POP**.'],
                        ['t' => 'Under **INCOMING MAIL SERVER**, enter:', 'f' => [['Host Name', $IMAP, $POP], ['User Name', $FULL], ['Password', $PW]]],
                        ['t' => 'Under **OUTGOING MAIL SERVER**, enter:', 'f' => [['Host Name', $OUT], ['User Name', $FULL], ['Password', $PW]],
                         'c' => ['important', 'Important', 'The outgoing User Name and Password say "Optional". Fill them in anyway. If you leave them blank, you\'ll receive email but won\'t be able to send it.']],
                        ['t' => 'Tap **Next**. Wait while your iPhone checks the settings (ticks appear next to each line).'],
                        ['t' => 'On the next screen, make sure **Mail** is switched on and tap **Save**.'],
                    ]],
                    ['title' => "Part 2: Check the security settings (don't skip this)", 'steps' => [
                        ['t' => 'Go back to **Settings > Apps > Mail > Mail Accounts** and tap your new account.'],
                        ['t' => 'Tap **Account** (the line showing your email address), then scroll down and tap **Advanced**.'],
                        ['t' => 'Under **INCOMING SETTINGS**, check:', 'f' => [['Use SSL', 'switched on (green)'], ['Authentication', 'Password'], ['Server Port', '`993`', '`995`']]],
                        ['t' => 'Tap **< Account** to go back.'],
                        ['t' => 'Under **OUTGOING MAIL SERVER**, tap **SMTP**, then tap **mta.extendcp.co.uk** (under Primary Server).'],
                        ['t' => 'Check:', 'f' => [['Server', 'switched on'], ['User Name and Password', 'filled in'], ['Use SSL', 'switched on'], ['Authentication', 'Password'], ['Server Port', '`587`']]],
                        ['t' => 'Tap **Done**, then **< Account**, then **Done**.'],
                    ]],
                ],
                'test' => "Open the Mail app and send an email to yourself. If it arrives, you're all set.",
                'pop'  => ['Using POP on iPhone?', 'In **Advanced**, set **Delete from server** to **Never** so your emails still reach your other devices.'],
            ]],
        ],
        [
            'id' => 'android', 'label' => 'Android', 'sub' => 'Gmail or Samsung Email',
            'heading' => 'Android phones and tablets',
            'variants' => [
                [
                    'id' => 'gmail', 'label' => 'Gmail app', 'desc' => 'Comes on almost every Android phone and works with any email address.',
                    'heading' => 'Android phones and tablets',
                    'intro' => 'Android phones vary by make. These steps use the **Gmail** app, which works with any email address, not just Gmail. Prefer the Samsung Email app? Switch to it below.',
                    'parts' => [['steps' => [
                        ['t' => 'Open the **Gmail** app.'],
                        ['t' => 'Tap your profile picture or initial in the top-right corner.'],
                        ['t' => 'Tap **Add another account**.'],
                        ['t' => 'Tap **Other** (not Google, Outlook or Yahoo).'],
                        ['t' => 'Type your full email address and tap **Manual setup**.'],
                        ['t' => 'Choose **Personal (IMAP)** (recommended) or **Personal (POP3)**, then tap **Next**.'],
                        ['t' => 'Enter your email password and tap **Next**.'],
                        ['t' => '**Incoming server settings.** Enter:', 'f' => [['Username', $FULL], ['Password', 'your email password (already filled in)'], ['Server', $IMAP, $POP], ['Port', '`993`', '`995`'], ['Security type', 'SSL/TLS']], 'a' => 'Tap **Next**.'],
                        ['t' => '**Outgoing server settings.** Enter:', 'f' => [['Require sign-in', 'switched on'], ['Username', $FULL], ['Password', $PW], ['SMTP server', $OUT], ['Port', '`587`'], ['Security type', 'STARTTLS']], 'a' => 'Tap **Next**.'],
                        ['t' => '**Account options.** Choose how often to check for new email (every 15 minutes is fine) and leave **Notify me when email arrives** ticked. Tap **Next**.'],
                        ['t' => 'Give the account a name (for example Work email), check **Your name** is how you want it to appear on emails you send, then tap **Next**.'],
                    ]]],
                    'notes' => [['tip', 'Screens look different?', 'Some screens look a little different depending on your phone and app version. The boxes might be in a different order, or Security type might be a drop-down. Just match each box to the settings above.']],
                    'test' => 'Switch to the new account (tap your profile picture and pick it), send an email to yourself, and check it arrives.',
                    'pop'  => ['Using POP3?', 'On the incoming settings screen, set **Delete email from server** to **Never** if you also read email on another device.'],
                ],
                [
                    'id' => 'samsung', 'label' => 'Samsung Email app', 'desc' => 'The built-in mail app on Samsung Galaxy phones.',
                    'heading' => 'Samsung Email app',
                    'parts' => [['steps' => [
                        ['t' => "Open **Samsung Email**. If it's your first account you'll go straight to setup; otherwise tap the menu (three lines) > cog icon > **Add account**."],
                        ['t' => 'Choose **Other**.'],
                        ['t' => 'Enter your full email address and password, then tap **Manual setup** (not Sign in).'],
                        ['t' => 'Choose **IMAP account** or **POP3 account**.'],
                        ['t' => 'Fill in the incoming and outgoing boxes:', 'f' => [['Username', $FULL], ['Incoming server', $IMAP, $POP], ['Port', '`993`', '`995`'], ['Security type', 'SSL/TLS'], ['Outgoing (SMTP) server', $OUT], ['Port', '`587`'], ['Security type', 'STARTTLS'], ['Require sign-in', 'switched on']], 'a' => 'Then tap **Sign in**.'],
                    ]]],
                    'test' => 'Send an email to yourself and check it arrives.',
                    'pop'  => ['Using POP3?', 'In the incoming settings, set **Delete email from server** to **Never** if you also read email on another device.'],
                ],
            ],
        ],
        [
            'id' => 'outlook', 'label' => 'Outlook on Windows', 'sub' => 'New or Classic Outlook',
            'heading' => 'Outlook on Windows',
            'intro' => 'There are two versions of Outlook on Windows that look quite different. Pick the one you have.',
            'variants' => [
                [
                    'id' => 'new', 'label' => 'New Outlook', 'desc' => 'Modern, simple look, with a New Outlook toggle in the top-right corner (switched on).',
                    'heading' => 'New Outlook',
                    'parts' => [['steps' => [
                        ['t' => 'Open Outlook and click the **Settings** cog in the top-right corner.'],
                        ['t' => 'Click **Accounts**, then **Email accounts**, then **Add account**.'],
                        ['t' => 'Type your full email address and click **Continue**.'],
                        ['t' => 'If Outlook asks you to choose a provider, choose **IMAP** (recommended) or **POP**.'],
                        ['t' => 'Click **Show more** (or **Advanced settings**) so all the boxes appear.'],
                        ['t' => 'Fill in:', 'f' => [['Email address', $FULL], ['IMAP / POP username', $FULL], ['IMAP / POP password', $PW], ['Incoming server', $IMAP, $POP], ['Port', '`993`', '`995`'], ['Secure connection type', 'SSL/TLS'], ['SMTP username', $FULL], ['SMTP password', $PW], ['SMTP server', $OUT], ['Port', '`587`'], ['Secure connection type', 'STARTTLS']]],
                        ['t' => "Click **Continue**. If Outlook mentions syncing your account through Microsoft's servers, click **Continue** again."],
                        ['t' => 'When you see a success message, click **Done**.'],
                    ]]],
                    'test' => 'Send an email to yourself and check it arrives in your Inbox.',
                ],
                [
                    'id' => 'classic', 'label' => 'Classic Outlook', 'desc' => 'Has a File menu in the top-left corner. Outlook 2016, 2019, 2021, 2024 and Microsoft 365.',
                    'heading' => 'Classic Outlook',
                    'parts' => [['steps' => [
                        ['t' => 'Open Outlook and click **File** in the top-left corner.'],
                        ['t' => 'Click **Add Account**.'],
                        ['t' => 'Type your full email address.'],
                        ['t' => 'Click **Advanced options** and tick **Let me set up my account manually**. Click **Connect**.'],
                        ['t' => 'Choose **IMAP** (recommended) or **POP**.'],
                        ['t' => 'Fill in the **Incoming mail** section:', 'f' => [['Server', $IMAP, $POP], ['Port', '`993`', '`995`'], ['Encryption method', 'SSL/TLS'], ['Require logon using Secure Password Authentication (SPA)', 'leave unticked']]],
                        ['t' => 'Fill in the **Outgoing mail** section:', 'f' => [['Server', $OUT], ['Port', '`587`'], ['Encryption method', 'STARTTLS'], ['Require logon using Secure Password Authentication (SPA)', 'leave unticked']]],
                        ['t' => 'Click **Next**, type your email password, and click **Connect**.'],
                        ['t' => 'When you see **Account successfully added**, click **Done**.'],
                    ]]],
                    'notes' => [['important', "Can't send email in Classic Outlook?", [
                        'Go to **File > Account Settings > Account Settings**, double-click your account, click **More Settings**, open the **Outgoing Server** tab and tick **My outgoing server (SMTP) requires authentication** with **Use same settings as my incoming mail server** selected. Click **OK**, then **Next**, then **Done**.',
                        'If double-clicking opens a single settings window with no More Settings button, click **Outgoing mail** in that window, tick **My outgoing (SMTP) server requires authentication** and click **Next**, then **Done**.',
                    ]]],
                    'test' => 'Send an email to yourself and check it arrives in your Inbox.',
                    'pop'  => ['Using POP in Classic Outlook?', 'In the **More Settings** window, open the **Advanced** tab and tick **Leave a copy of messages on the server**. Ticking **Remove from server after 14 days** as well stops your mailbox filling up.'],
                ],
            ],
        ],
        [
            'id' => 'mac', 'label' => 'Mac', 'sub' => 'Apple Mail',
            'variants' => [[
                'id' => 'macmail', 'heading' => 'Apple Mail on a Mac',
                'parts' => [
                    ['title' => 'Part 1: Add the account', 'steps' => [
                        ['t' => 'Open the **Mail** app.'],
                        ['t' => 'In the menu bar at the top of the screen, click **Mail > Add Account**.'],
                        ['t' => 'Choose **Other Mail Account** and click **Continue**.'],
                        ['t' => 'Fill in:', 'f' => [['Name', 'your name as you want people to see it'], ['Email Address', $FULL], ['Password', $PW]]],
                        ['t' => 'Click **Sign In**. You\'ll probably see "Unable to verify account name or password". This is normal. More boxes will appear.'],
                        ['t' => 'Fill in the extra boxes:', 'f' => [['Email Address', 'your full email address (already filled in)'], ['User Name', 'your full email address (it may say Automatic; replace it)'], ['Password', $PW], ['Account Type', 'IMAP (recommended) or POP'], ['Incoming Mail Server', $IMAP, $POP], ['Outgoing Mail Server', $OUT]]],
                        ['t' => 'Click **Sign In**.'],
                        ['t' => 'Make sure **Mail** is ticked and click **Done**.'],
                    ]],
                    ['title' => "Part 2: Check the server settings (don't skip this)", 'steps' => [
                        ['t' => 'In the menu bar, click **Mail > Settings** (on older Macs: **Mail > Preferences**).'],
                        ['t' => 'Click **Accounts** at the top, then choose your new account from the list on the left.'],
                        ['t' => 'Click the **Server Settings** tab.'],
                        ['t' => 'In the **Incoming Mail Server** section:', 'f' => [['User Name / Password', 'your full email address, password filled in'], ['Automatically manage connection settings', 'unticked'], ['Port', '`993`', '`995`'], ['Use TLS/SSL', 'ticked'], ['Authentication', 'Password']]],
                        ['t' => 'In the **Outgoing Mail Server (SMTP)** section:', 'f' => [['User Name / Password', "your full email address, password filled in, even if it's marked as optional"], ['Automatically manage connection settings', 'unticked'], ['Port', '`587`'], ['Use TLS/SSL', 'ticked'], ['Authentication', 'Password']]],
                        ['t' => 'Click **Save**, then close the Settings window.'],
                    ]],
                ],
                'test' => 'Send an email to yourself and check it arrives.',
                'pop'  => ['Using POP on a Mac?', "In the account's **Advanced** tab, untick **Remove copy from server after retrieving a message**, or set it to remove after one or two weeks, if you also read email on other devices."],
            ]],
        ],
    ],

    'trouble' => [
        ['q' => '"Incorrect password", "Authentication failed" or "Cannot verify account"', 'items' => [
            "Check the username is your **full email address**, everywhere it's asked for, including the outgoing (SMTP) section.",
            'Retype your password carefully. Passwords are case-sensitive, and phones often add a capital letter at the start without you noticing.',
            "Check the password works by logging in to webmail (see below). If it doesn't work there either, ask us to reset it.",
        ]],
        ['q' => '"Cannot connect to server" or the setup hangs', 'items' => [
            'Check the server names for typos: `imap.extendcp.co.uk`, `pop3.extendcp.co.uk`, `mta.extendcp.co.uk`. No spaces, and extendcp is one word.',
            'Check the ports and security: **993 + SSL/TLS** (IMAP), **995 + SSL/TLS** (POP), **587 + STARTTLS** (outgoing).',
            'Try on a different connection, for example switch from Wi-Fi to mobile data. Some office and public Wi-Fi networks block email.',
        ]],
        ['q' => "I can receive email but can't send it", 'intro' => 'This is almost always the outgoing (SMTP) settings.', 'items' => [
            "Check the outgoing username and password are filled in, even if the screen says they're optional.",
            'Check **outgoing server requires authentication** (or **Require sign-in**) is switched on.',
            'Check the outgoing server is `mta.extendcp.co.uk` and the port is **587** with **STARTTLS**.',
        ]],
        ['q' => 'I can send email but not receive it', 'items' => [
            'Check the incoming server, port and security settings.',
            "Log in to webmail. If new emails are there, the problem is on your device.",
            "If they aren't in webmail either, check the [system status](/#status). If there's a problem with email, it's already being fixed, so wait and check again later. If everything shows as operational, contact us.",
        ]],
        ['q' => 'Emails have disappeared from my other devices', 'items' => [
            'One of your devices is probably set up as POP and is removing emails from the server after downloading them. Switch on **leave a copy on the server** on that device, or remove the account and add it again as IMAP.',
        ]],
        ['q' => 'I get a warning about a security certificate', 'items' => [
            "Check you used the extendcp.co.uk server names in this guide, not mail.yourdomain.co.uk. With the right server names you shouldn't see this warning.",
        ]],
        ['q' => 'It worked before and has suddenly stopped', 'items' => [
            "Check the [system status](/#status). If there's a problem with email, it's already being fixed. There's nothing to change on your device, so wait and try again later.",
            "If you've recently changed your email password (for example in webmail), update it on every device.",
            'Too many wrong password attempts can lock your mailbox for a while. Remove the account from any old devices still trying the wrong password, wait at least 30 minutes and try again.',
        ]],
    ],
];
