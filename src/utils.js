import moment from 'moment-timezone';

export const calculateTimeAgo = (modifiedGmt) => {
  const clientTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  // Create a moment object representing the time the job was last modified in UTC.
  const modifiedUtc = moment.utc(modifiedGmt);
  // Convert the moment object to the client's timezone.
  const modifiedInClientTimezone = modifiedUtc.tz(clientTimezone);
  // Return the duration between the current time and the modified time in human-readable format (e.g. 2 days ago, 10 minutes ago)
  return modifiedInClientTimezone.fromNow();
};