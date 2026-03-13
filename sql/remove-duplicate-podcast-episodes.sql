-- Remove duplicate podcast episodes, keeping one per (podcast_name, episode_title)
-- Run: mysql -h 127.0.0.1 -P 8889 -u root -proot darrenn < sql/remove-duplicate-podcast-episodes.sql

DELETE FROM podcast_episodes
WHERE id NOT IN (
    SELECT keep_id FROM (
        SELECT MIN(id) AS keep_id FROM podcast_episodes GROUP BY podcast_name, episode_title
    ) AS keep_ids
);

-- Prevent future duplicates (optional; run separately if the above fails)
-- ALTER TABLE podcast_episodes ADD UNIQUE KEY uk_podcast_episode (podcast_name, episode_title);
