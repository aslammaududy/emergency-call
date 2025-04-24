import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
import { formatDistanceToNow } from 'date-fns'

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function formatRelativeTime(dateString: string): string {
    const date = new Date(dateString)
    return formatDistanceToNow(date, { addSuffix: true })
  }
  
  export function getStatusColor(status: string): string {
    switch (status.toLowerCase()) {
      case 'waiting':
        return 'bg-blue-100 text-blue-800 border-blue-300'
      case 'dispatched':
        return 'bg-amber-100 text-amber-800 border-amber-300'
      case 'completed':
        return 'bg-green-100 text-green-800 border-green-300'
      default:
        return 'bg-gray-100 text-gray-800 border-gray-300'
    }
  }
  
  export function getStatusDotColor(status: string): string {
    switch (status.toLowerCase()) {
      case 'waiting':
        return 'bg-status-waiting'
      case 'dispatched':
        return 'bg-status-dispatched'
      case 'completed':
        return 'bg-status-completed'
      default:
        return 'bg-gray-400'
    }
  }