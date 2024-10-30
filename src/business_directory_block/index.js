/**
 * Block dependencies
 */

import edit from './edit';

import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { dateI18n, format, __experimentalGetSettings } from '@wordpress/date';
import { setState } from '@wordpress/compose';

registerBlockType( 'cdash-bd-blocks/business-directory', {
    title: 'Display Business Directory',
    icon: 'store',
    category: 'cd-blocks',
    description: 'The business directory block displays the Business Directoy listings on your page.',
    example: {
    },
    supports: {
        // Declare support for block's alignment.
        // This adds support for all the options:
        // left, center, right, wide, and full.
        align: [ 'wide', 'full' ]
    },
    attributes: {
        align: {
            type: 'string',
            default: ''
        },
        textAlignment: {
            type: 'string',
            default: 'left',
        },
        cd_block:{
            type: 'string',
            default: 'yes',
        },
        postLayout: {
             type: 'string',
             default: 'grid3',
	},
        format: {
            type: 'string',
            default: 'grid3',
        },
        categoryArray:{
            type: 'array',
            default: [],
        },
        category:{
            type: 'string',
            default: '',
        },
        tags:{
            type: 'string',
            default: '',
        },
        membershipLevelArray:{
            type: 'array',
            default: [],
        },
        level:{
            type: 'string',
            default: '',
        },
        displayPostContent:{
            type:Boolean,
            default: true,        
        },
        text:{
            type: 'string',
            default: 'none',
        },
        singleLinkToggle: {
            type: 'boolean',
            default: true,
        },
        single_link:{
            type: 'string',
            default: 'yes',
        },
        perpage:{
            type: 'number',
            default: -1,
        },
        orderby:{
            type: 'string',
            default: 'title',
        },
        order:{
            type: 'string',
            default: 'asc',
        },
        image:{
            type: 'string',
            default: 'featured',
        },
        membershipStatusArray:{
            type: 'array',
            default: [],
        },
        status:{
            type: 'string',
            default: '',
        },
        image_size:{
            type: 'string',
            default: 'medium',
        },
        alphaToggle:{
            type: 'boolean',
            default: false,
        },
        alpha:{
            type: 'string',
            default: 'no',
        },
        logo_gallery:{
            type: 'string',
            default: 'no',
        },
        categoryFilterToggle:{
            type: 'boolean',
            default: false,
        },
        show_category_filter:{
            type: 'string',
            default: 'no',
        },
        display:{
            type: 'string',
            default: '',
        },
        displayAddressToggle:{
            type: 'boolean',
            default: false,
        },
        displayUrlToggle:{
            type: 'boolean',
            default: false,
        },
        displayPhoneToggle:{
            type: 'boolean',
            default: false,
        },
        displayEmailToggle:{
            type: 'boolean',
            default: false,
        },
        displayCategoryToggle:{
            type: 'boolean',
            default: false,
        },
        displayTagsToggle:{
            type: 'boolean',
            default: false,
        },
        displayLevelToggle:{
            type: 'boolean',
            default: false,
        },
        displaySocialMediaIconsToggle:{
            type: 'boolean',
            default: false,
        },
        displayLocationNameToggle:{
            type: 'boolean',
            default: false,
        },
        displayHoursToggle:{
            type: 'boolean',
            default: false,
        },
        changeTitleFontSize:{
            type: 'boolean',
            default: false,
        },
        titleFontSize:{
            type: 'number',
            default: 16,
        },
        disablePagination:{
            type: 'boolean',
            default: false,
        },
        displayImageOnTop:{
            type: 'boolean',
            default: false,
        },
        enableBorder: {
            type: 'boolean',
            default: false,
        },
        borderColor: {
            type: 'string',
            default: '#000000',
        },
        borderThickness: {
            type: 'number',
            default: 1,
        },
        borderStyle: {
            type: 'string',
            default: 'solid',
        },
        borderRadius: {
            type: 'number',
            default: 0,
        },
        borderRadiusUnits: {
            type: 'string',
            default: 'px',
        },
    },
    edit: edit,
    save() {
        // Rendering in PHP
        return null;
    },
} );