/**
 * Block dependencies
 */

import edit from './edit';

import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { dateI18n, format, __experimentalGetSettings } from '@wordpress/date';
import { setState } from '@wordpress/compose';

registerBlockType( 'cdash-bd-blocks/business-directory-search', {
    title: 'CD Business Search Block',
    icon: 'search',
    category: 'cd-blocks',
    description: 'The business directory search block displays the search form on your page.',
    example: {
    },
    attributes: {
        searchFormTitleDisplay:{
            type: 'boolean',
            default: true,
        },
        searchFormCustomTitle: {
            type: 'string',
            default: 'Search'
        },
        searchFormAlignment:{
            type: 'string',
            default: 'left',
        },
        searchFormLabelDisplay:{
            type: 'boolean',
            default: true,
        },
        customSearchFormLabel: {
            type: 'string',
            default: 'Search Text'
        },
        categoryFieldDisplay:{
            type: 'boolean',
            default: true,
        },
        categoryFieldLabelDisplay:{
            type: 'boolean',
            default: true,
        },
        customCategoryFieldLabel:{
            type: 'string',
            default: '',
        },
        searchInputPlaceholder:{
            type: 'string',
            default: '',
        },
        searchDisplayFormat:{
            type: 'string',
            default: 'list',
        },
        imageType:{
            type: 'string',
            default: 'featured',
        },
        imageSize:{
            type: 'string',
            default: 'medium',
        },
        imageAlignment:{
            type: 'string',
            default: 'left',
        },
        perPage:{
            type: 'number',
            default: -1,
        },
        orderBy:{
            type: 'string',
            default: 'title',
        },
        order:{
            type: 'string',
            default: 'asc',
        },
        displayDescription: {
            type: 'boolean',
            default: true,
        },
        displayMemberLevel:{
            type: 'boolean',
            default: true,
        },
        displayCategory:{
            type: 'boolean',
            default: true,
        },
        displayTags:{
            type: 'boolean',
            default: true,
        },
        displaySocialMedia:{
            type: 'boolean',
            default: true,
        },
        displayLocationName:{
            type: 'boolean',
            default: true,
        },
        displayAddress:{
            type: 'boolean',
            default: true,
        },
        displayWebsite:{
            type: 'boolean',
            default: true,
        },
        displayHours:{
            type: 'boolean',
            default: true,
        },
        displayPhone:{
            type: 'boolean',
            default: true,
        },
        displayEmail:{
            type: 'boolean',
            default: true,
        },
        businessTitleFontSize:{
            type: 'number',
            default: 26,
        },
        businessLocationNameFontSize:{
            type: 'number',
            default: 26,
        },
    },
    edit: edit,
    save() {
        // Rendering in PHP
        return null;
    },
} );