# WhatsApp Chatbot Setup Guide - Atlas Digitalize

## Overview

This guide explains how to set up and optimize the WhatsApp chatbot using n8n and WAHA for Atlas Digital Cipta Teknologi.

## Available Workflows

| File                                       | Description                                                |
| ------------------------------------------ | ---------------------------------------------------------- |
| `Whatsapp_Chatbot_Atlas_Optimized.json`    | Responds to ALL messages                                   |
| `Whatsapp_Chatbot_Atlas_With_Trigger.json` | **Recommended** - Only responds when triggered by keywords |

## Architecture

```
Customer (WhatsApp) → WAHA (WebJS) → n8n Workflow → AI Agent (DeepSeek) → Atlas API
```

## Trigger Keywords (With_Trigger version)

The bot will ONLY respond when a message contains these keywords:

- `atlas`
- `halo atlas`
- `hello atlas`
- `hai atlas`
- `hi atlas`

### How Session Works

1. **Session Start**: Customer sends message with "Atlas" keyword
2. **Session Active**: Bot responds to ALL subsequent messages from that customer
3. **Session Timeout**: After 30 minutes of inactivity, session ends
4. **Session End Keywords**: `bye`, `selesai`, `terima kasih`, `thanks`, `exit`, `quit`

### Website CTA Integration

Configure your website's WhatsApp CTA button with a pre-filled message:

```
https://wa.me/62XXXXXXXXXX?text=Halo%20Atlas%2C%20saya%20ingin%20bertanya
```

This ensures the chatbot activates when users click from your website.

## Features

### 1. **Interactive Menu System**

When customer first chats, the bot offers:

- 1️⃣ Informasi tentang Atlas Digital
- 2️⃣ Layanan & Solusi kami
- 3️⃣ Portfolio & Proyek
- 4️⃣ Jadwalkan Konsultasi
- 5️⃣ Bicara dengan Tim Kami

### 2. **AI-Powered Responses**

- Uses DeepSeek LLM for natural conversation
- Per-session memory (remembers conversation context)
- Indonesian language optimized

### 3. **API Tools Available to AI Agent**

| Tool                  | API Endpoint              | Purpose                          |
| --------------------- | ------------------------- | -------------------------------- |
| `get_company_info`    | GET `/api/about`          | Company profile, vision, mission |
| `get_solutions`       | GET `/api/solutions`      | List all services                |
| `get_solution_detail` | GET `/api/solutions/{id}` | Specific service details         |
| `get_projects`        | GET `/api/projects`       | Portfolio list                   |
| `get_project_detail`  | GET `/api/projects/{id}`  | Project case study               |
| `get_clients`         | GET `/api/clients`        | Client list/testimonials         |
| `get_insights`        | GET `/api/insights`       | Blog articles                    |
| `submit_appointment`  | POST `/api/contacts`      | Schedule consultation            |

### 4. **Lead Tracking**

Appointments submitted via chatbot include `source: "whatsapp_chatbot"` for analytics.

## Setup Instructions

### Step 1: Import Workflow

1. Open n8n (your instance)
2. Go to Workflows → Import from File
3. Select `Whatsapp_Chatbot_Atlas_Optimized.json`

### Step 2: Configure Credentials

1. **WAHA API**: Update credential `n5mRTjBO5rbghKbN` with your WAHA instance URL and API key
2. **DeepSeek API**: Update credential `GkgyftLiUHYqwyTt` with your DeepSeek API key

### Step 3: Configure WAHA Webhook

1. In WAHA dashboard, set webhook URL to your n8n trigger URL
2. Enable events: `message`, `message.any`

### Step 4: Run Database Migration

```bash
php artisan migrate
```

This adds the `source` field to contacts table.

### Step 5: Activate Workflow

1. Test with a few messages first
2. Once working, toggle workflow to Active

## Customization

### Change Greeting Message

Edit the System Message in "Atlas AI Agent" node:

```
## Menu Utama (Tawarkan saat greeting awal)
Ketika customer pertama kali chat atau bilang 'menu', tawarkan opsi:
1️⃣ Informasi tentang Atlas Digital
...
```

### Add Human Handoff

To implement human handoff when customer selects option 5:

1. Add a **Code** node after AI Agent to detect handoff intent
2. Route to a separate flow that:
    - Notifies admin (via another WhatsApp message or email)
    - Sends customer a "Connecting you to our team..." message

### Add Business Hours Check

Insert a **Schedule Trigger** or **If** node to:

- Check current time against business hours
- Respond with "We're currently offline" outside hours
- Still allow AI for basic queries 24/7

## Recommended Enhancements

### 1. **Add Rate Limiting**

Prevent spam by limiting messages per user:

```javascript
// In a Code node
const chatId = $json.chatId;
const lastMessage = $getWorkflowStaticData("user")[chatId];
const now = Date.now();

if (lastMessage && now - lastMessage < 3000) {
    return []; // Skip if less than 3 seconds
}

$getWorkflowStaticData("user")[chatId] = now;
return $input.all();
```

### 2. **Add Image Support**

For project portfolio, create a tool that sends images:

```javascript
// After AI mentions a project, detect and send image
if ($json.output.includes("portfolio") && projectData.image_url) {
    // Add Send Image node
}
```

### 3. **Analytics Dashboard**

Track in your database:

- Total conversations
- Most asked questions
- Conversion rate (chat → appointment)
- Response times

## Troubleshooting

### Bot not responding

1. Check WAHA webhook is correctly configured
2. Verify n8n workflow is active
3. Check WAHA session is connected (scan QR if needed)

### AI giving wrong information

1. Review tool descriptions - they guide AI when to use each tool
2. Check API endpoints are returning correct data
3. Adjust system prompt for better context

### Messages duplicating

1. Add unique message ID check in workflow
2. Ensure webhook is only configured once

## API Optimization Suggestions

Consider adding these endpoints to enhance chatbot capabilities:

1. **GET `/api/solutions/summary`** - Compact list for chatbot (title + short description only)
2. **GET `/api/faq`** - Frequently asked questions
3. **GET `/api/business-hours`** - Operating hours for human handoff logic
4. **POST `/api/chatbot/log`** - Log chatbot conversations for analytics

## Files Modified

- `app/Models/Contact.php` - Added `source` field
- `app/Http/Requests/StoreContactRequest.php` - Added `source` validation
- `database/migrations/2026_02_06_100000_add_source_to_contacts_table.php` - New migration
