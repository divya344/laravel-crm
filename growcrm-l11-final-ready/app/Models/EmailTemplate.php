<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'email_templates';
    protected $primaryKey = 'emailtemplate_id';
    protected $guarded = ['emailtemplate_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'emailtemplate_created';
    const UPDATED_AT = 'emailtemplate_updated';

    protected $casts = [
        'emailtemplate_created' => 'datetime',
        'emailtemplate_updated' => 'datetime',
    ];

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('emailtemplate_status', 'active');
    }

    /**
     * Scope for a specific type (e.g. 'invoice', 'welcome').
     */
    public function scopeType($query, string $type)
    {
        return $query->where('emailtemplate_type', $type);
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get a human-readable template name.
     */
    public function getDisplayNameAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->emailtemplate_name ?? 'Untitled Template'));
    }

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->emailtemplate_created
            ? $this->emailtemplate_created->format('d M Y, h:i A')
            : null;
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Parse the template body or subject and replace {shortcodes} with real data.
     *
     * @param string $section  'body' or 'subject'
     * @param array  $data     key-value data for placeholders
     * @return string
     */
    public function parse(string $section = 'body', array $data = []): string
    {
        // Validate section
        if (!in_array($section, ['body', 'subject'])) {
            return $this->emailtemplate_body ?? '';
        }

        // Get content to parse
        $content = $section === 'body'
            ? $this->emailtemplate_body
            : $this->emailtemplate_subject;

        // Replace {shortcodes} with real data
        return preg_replace_callback('/{(.*?)}/', function ($matches) use ($data) {
            $key = trim($matches[1]);
            return $data[$key] ?? $matches[0]; // leave untouched if not found
        }, $content) ?? '';
    }

    /**
     * Generate an email ready for sending.
     *
     * @param array $data
     * @return array
     */
    public function buildEmail(array $data = []): array
    {
        return [
            'subject' => $this->parse('subject', $data),
            'body' => $this->parse('body', $data),
        ];
    }
}
