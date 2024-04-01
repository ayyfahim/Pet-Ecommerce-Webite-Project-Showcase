import { IBaseDBSchema } from 'schemas/baseSchema'

export type IMediaSchema = IBaseDBSchema<{
  originalName: string
  mimeType: string
  fileSize?: number
  relativePath?: string
  status: 'draft' | 'published'
  description?: string
  info?: string
  uri: {
    original: string
  }
  permission?: boolean
}>
