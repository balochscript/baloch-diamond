import os
import re

pot_file_path = "baloch-diamond/baloch-diamond/languages/baloch-diamond.pot"
theme_dir = "baloch-diamond/baloch-diamond"

# Regex patterns to match gettext functions in PHP
patterns = [
    r'__\(\s*[\'"](.*?)[\'"]\s*,\s*[\'"]baloch-diamond[\'"]\s*\)',
    r'_e\(\s*[\'"](.*?)[\'"]\s*,\s*[\'"]baloch-diamond[\'"]\s*\)',
    r'esc_html__\(\s*[\'"](.*?)[\'"]\s*,\s*[\'"]baloch-diamond[\'"]\s*\)',
    r'esc_html_e\(\s*[\'"](.*?)[\'"]\s*,\s*[\'"]baloch-diamond[\'"]\s*\)',
    r'esc_attr__\(\s*[\'"](.*?)[\'"]\s*,\s*[\'"]baloch-diamond[\'"]\s*\)',
    r'esc_attr_e\(\s*[\'"](.*?)[\'"]\s*,\s*[\'"]baloch-diamond[\'"]\s*\)',
    r'_n\(\s*[\'"](.*?)[\'"]\s*,\s*[\'"](.*?)[\'"]\s*,\s*.*?\s*,\s*[\'"]baloch-diamond[\'"]\s*\)'
]

extracted_strings = set()

# Walk through theme files
for root, dirs, files in os.walk(theme_dir):
    for file in files:
        if file.endswith('.php'):
            file_path = os.path.join(root, file)
            with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
                content = f.read()
                for pattern in patterns:
                    matches = re.findall(pattern, content)
                    for match in matches:
                        if isinstance(match, tuple):
                            extracted_strings.add(match[0])
                            extracted_strings.add(match[1])
                        else:
                            extracted_strings.add(match)

# Read existing msgids in POT file to prevent duplicates
existing_msgids = set()
if os.path.exists(pot_file_path):
    with open(pot_file_path, 'r', encoding='utf-8', errors='ignore') as f:
        pot_content = f.read()
        existing_msgids = set(re.findall(r'^msgid\s+[\'"](.*?)[\'"]', pot_content, re.MULTILINE))

# Filter out empty string and any that are already in POT
new_strings = [s for s in extracted_strings if s and s not in existing_msgids]

if new_strings:
    print(f"Adding {len(new_strings)} new translation strings to POT file.")
    with open(pot_file_path, 'a', encoding='utf-8') as f:
        f.write("\n\n# New strings added in v1.1.0\n")
        for string in sorted(new_strings):
            escaped_string = string.replace('"', '\\"')
            f.write(f'msgid "{escaped_string}"\n')
            f.write('msgstr ""\n\n')
else:
    print("No new translation strings found.")
